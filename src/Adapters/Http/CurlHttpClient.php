<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\Http;

use RuntimeException;

final class CurlHttpClient implements HttpClient
{
    public function __construct(private readonly ?string $baseUrl = null) {}

    public function request(string $method, string $url, array $headers = [], ?array $body = null, int $timeout = 30): array
    {
        $full = ($this->baseUrl ? rtrim($this->baseUrl,'/').'/' : '').ltrim($url,'/');
        $ch = curl_init($full);

        $h = [];
        foreach ($headers as $k => $v) {
            $h[] = is_int($k) ? $v : $k . ': ' . $v;
        }

        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $h,
            CURLOPT_TIMEOUT        => $timeout,
        ]);

        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        }

        $raw = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($raw === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException('cURL error: '.$err);
        }
        curl_close($ch);

        $json = json_decode($raw, true);
        if ($code >= 400) {
            throw new RuntimeException('HTTP '.$code.': '.$raw, $code);
        }
        return is_array($json) ? $json : ['raw' => $raw, 'http_code' => $code];
    }
}
