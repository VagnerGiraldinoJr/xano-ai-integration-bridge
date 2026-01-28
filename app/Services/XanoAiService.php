<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class XanoAiService
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->baseUrl = config('services.xano.base_url');
        $this->token = config('services.xano.key');
    }


    public function normalizePhone(string $phone)
    {
        $response = Http::withToken($this->token)
            ->get("{$this->baseUrl}/phoneNormalization/{$phone}");

        return $response->json();
    }


    public function sendMessage(string $phone, string $message)
    {
        $response = Http::withToken($this->token)
            ->post("{$this->baseUrl}/message/send", [
                'phoneNumber' => $phone,
                'textContent' => $message,
                'sendNow' => true,
                'type' => 'texto'
            ]);

        return $response->json();
    }
}
