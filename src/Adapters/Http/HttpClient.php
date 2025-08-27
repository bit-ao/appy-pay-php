<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\Http;

interface HttpClient
{
    /** @return array Decoded JSON */
    public function request(string $method, string $url, array $headers = [], ?array $body = null, int $timeout = 30): array;
}
