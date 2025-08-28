<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\Http;

/**
 * Interface HttpClient
 * @package Bit\AppyPay\Adapters\Http
 */
interface HttpClient
{

    /**
     * @param string $method
     * @param string $url
     * @param array $headers
     * @param array|null $body
     * @param int $timeout
     * @return array
     */
    public function request(string $method, string $url, array $headers = [], ?array $body = null, int $timeout = 30): array;
}
