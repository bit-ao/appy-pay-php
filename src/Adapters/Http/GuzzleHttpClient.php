<?php

namespace Bit\AppyPay\Adapters\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\TransferStats;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Psr7\UriResolver;
use Psr\Http\Message\UriInterface;
use RuntimeException;

class GuzzleHttpClient implements HttpClient
{
    /** @var Client|ClientInterface */
    private ClientInterface|Client $client;

    /** Guarda a URL efetiva do último request */
    private ?UriInterface $lastEffectiveUri = null;

    public function __construct(?string $baseUrl = null, ?ClientInterface $client = null)
    {
        $this->client = $client ?? new Client([
            'base_uri'    => $baseUrl ? rtrim($baseUrl, '/') . '/' : null,
            'http_errors' => false, // tratamos manualmente 4xx/5xx
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function request(string $method, string $url, array $headers = [], ?array $body = null, int $timeout = 30): array
    {
        $options = [
            'headers' => $headers,
            'timeout' => $timeout,

            // Captura métricas da transferência (inclui a URL efetiva)
            'on_stats' => function (TransferStats $stats) {
                $this->lastEffectiveUri = $stats->getEffectiveUri();
            },
        ];

        $contentType = strtolower((string)($headers['Content-Type'] ?? ''));
        if ($body !== null) {
            if (str_contains($contentType, 'application/x-www-form-urlencoded')) {
                $options['form_params'] = $body;
            } elseif (isset($body['_raw'])) {
                $options['body'] = (string)$body['_raw'];
            } else {
                $options['json'] = $body;
            }
        }

        // NUNCA dê dd($resp) aqui; isso só mostra a resposta e mata a execução.
        $resp   = $this->client->request($method, ltrim($url, '/'), $options);

        $status = $resp->getStatusCode();
        $raw    = (string)$resp->getBody();
        $json   = json_decode($raw, true);

        if ($status >= 400) {
            $effective = (string)($this->lastEffectiveUri ?? $this->resolveUri($url));
            throw new RuntimeException('HTTP ' . $status . ' at ' . $effective . ': ' . $raw, $status);
        }

        return is_array($json) ? $json : ['raw' => $raw, 'http_code' => $status];
    }

    /** URL efetiva do último request (útil para logs/tests) */
    public function getLastEffectiveUri(): ?string
    {
        return $this->lastEffectiveUri?->__toString();
    }

    /** Resolve base_uri + url (fallback caso on_stats não rode) */
    private function resolveUri(string $url): UriInterface
    {
        /** @var UriInterface|null $base */
        $base = $this->client->getConfig('base_uri');
        $rel  = new Uri(ltrim($url, '/'));
        return $base ? UriResolver::resolve($base, $rel) : $rel;
    }

    public function getClient(): Client|ClientInterface
    {
        return $this->client;
    }

    public function setClient(Client|ClientInterface $client): void
    {
        $this->client = $client;
    }
}
