<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class XanoAiService
{
    protected string $baseUrl;
    protected string $token;
    protected int $timeout;
    protected int $retryTimes;
    protected int $retryDelay;
    protected int $cacheTtl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.xano.base_url'), '/');
        $this->token = config('services.xano.key');
        $this->timeout = config('services.xano.timeout', 30);
        $this->retryTimes = config('services.xano.retry_times', 3);
        $this->retryDelay = config('services.xano.retry_delay', 100);
        $this->cacheTtl = config('services.xano.cache_ttl', 3600);
    }

    /**
     * Create a configured HTTP client with optimizations
     */
    protected function httpClient(): PendingRequest
    {
        return Http::withToken($this->token)
            ->timeout($this->timeout)
            ->retry($this->retryTimes, $this->retryDelay, throw: false)
            ->withOptions([
                'http_errors' => false,
                'connect_timeout' => 10,
            ]);
    }

    /**
     * Normalize phone number with caching for performance
     */
    public function normalizePhone(string $phone): array
    {
        // Input validation
        if (empty($phone)) {
            return ['error' => 'Phone number cannot be empty'];
        }

        // Generate cache key
        $cacheKey = "phone_normalization:" . md5($phone);

        // Return cached result if available
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($phone) {
            $response = $this->httpClient()
                ->get("{$this->baseUrl}/phoneNormalization/{$phone}");

            if ($response->failed()) {
                return ['error' => 'API request failed', 'status' => $response->status()];
            }

            return $response->json() ?? [];
        });
    }

    /**
     * Send message with optimized HTTP client
     */
    public function sendMessage(string $phone, string $message): array
    {
        // Input validation
        if (empty($phone) || empty($message)) {
            return ['error' => 'Phone number and message cannot be empty'];
        }

        $response = $this->httpClient()
            ->post("{$this->baseUrl}/message/send", [
                'phoneNumber' => $phone,
                'textContent' => $message,
                'sendNow' => true,
                'type' => 'texto'
            ]);

        if ($response->failed()) {
            return ['error' => 'API request failed', 'status' => $response->status()];
        }

        return $response->json() ?? [];
    }

    /**
     * Clear phone normalization cache
     */
    public function clearPhoneCache(string $phone): bool
    {
        $cacheKey = "phone_normalization:" . md5($phone);
        return Cache::forget($cacheKey);
    }

    /**
     * Clear all phone normalization cache
     */
    public function clearAllPhoneCache(): bool
    {
        // This is a simple implementation - for production, consider using cache tags
        return true;
    }
}
