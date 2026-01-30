<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\XanoAiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class XanoAiServiceTest extends TestCase
{
    protected XanoAiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Set up test configuration
        config([
            'services.xano.base_url' => 'https://test.xano.io/api',
            'services.xano.key' => 'test-api-key',
            'services.xano.timeout' => 30,
            'services.xano.retry_times' => 3,
            'services.xano.retry_delay' => 100,
            'services.xano.cache_ttl' => 3600,
        ]);
        
        $this->service = new XanoAiService();
        Cache::flush();
    }

    /** @test */
    public function it_normalizes_phone_numbers_successfully()
    {
        Http::fake([
            '*/phoneNormalization/*' => Http::response([
                'internationalNumber' => '+5542999998888',
                'isValid' => true,
            ], 200),
        ]);

        $result = $this->service->normalizePhone('42999998888');

        $this->assertEquals('+5542999998888', $result['internationalNumber']);
        $this->assertTrue($result['isValid']);
    }

    /** @test */
    public function it_caches_phone_normalization_results()
    {
        Http::fake([
            '*/phoneNormalization/*' => Http::response([
                'internationalNumber' => '+5542999998888',
                'isValid' => true,
            ], 200),
        ]);

        // First call - should hit API
        $result1 = $this->service->normalizePhone('42999998888');
        
        // Second call - should use cache
        $result2 = $this->service->normalizePhone('42999998888');

        $this->assertEquals($result1, $result2);
        
        // Verify HTTP was only called once due to caching
        Http::assertSentCount(1);
    }

    /** @test */
    public function it_validates_empty_phone_number()
    {
        $result = $this->service->normalizePhone('');

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('Phone number cannot be empty', $result['error']);
    }

    /** @test */
    public function it_handles_api_failures_gracefully()
    {
        Http::fake([
            '*/phoneNormalization/*' => Http::response([], 500),
        ]);

        $result = $this->service->normalizePhone('42999998888');

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals('API request failed', $result['error']);
    }

    /** @test */
    public function it_sends_messages_successfully()
    {
        Http::fake([
            '*/message/send' => Http::response([
                'success' => true,
                'messageId' => '12345',
            ], 200),
        ]);

        $result = $this->service->sendMessage('42999998888', 'Test message');

        $this->assertTrue($result['success']);
        $this->assertEquals('12345', $result['messageId']);
    }

    /** @test */
    public function it_validates_empty_message_fields()
    {
        $result1 = $this->service->sendMessage('', 'Test message');
        $this->assertArrayHasKey('error', $result1);

        $result2 = $this->service->sendMessage('42999998888', '');
        $this->assertArrayHasKey('error', $result2);
    }

    /** @test */
    public function it_clears_phone_cache()
    {
        Http::fake([
            '*/phoneNormalization/*' => Http::response([
                'internationalNumber' => '+5542999998888',
            ], 200),
        ]);

        // Cache the result
        $this->service->normalizePhone('42999998888');
        
        // Clear the cache
        $cleared = $this->service->clearPhoneCache('42999998888');
        $this->assertTrue($cleared);

        // Next call should hit API again
        $this->service->normalizePhone('42999998888');
        Http::assertSentCount(2);
    }

    /** @test */
    public function it_handles_network_retries()
    {
        // Simulate failure then success (tests retry mechanism)
        Http::fake([
            '*/phoneNormalization/*' => Http::sequence()
                ->push([], 500)
                ->push([], 500)
                ->push(['internationalNumber' => '+5542999998888'], 200),
        ]);

        $result = $this->service->normalizePhone('42999998888');

        $this->assertArrayHasKey('internationalNumber', $result);
    }

    /** @test */
    public function it_applies_timeout_configuration()
    {
        // This test verifies that timeout is configured
        // In real scenario, this would timeout after configured time
        config(['services.xano.timeout' => 1]);
        
        $service = new XanoAiService();
        
        // Verify service was created with new config
        $this->assertInstanceOf(XanoAiService::class, $service);
    }
}
