<?php
declare(strict_types=1);
namespace Bit\AppyPay\Adapters\Http;
use Bit\AppyPay\Core\Contracts\TokenProviderPort;
use Throwable;

final class AuthenticatedHttpClient implements HttpClient
{
    public function __construct(
        private HttpClient $inner,
        private TokenProviderPort $tokens
    ) {}

    /**
     * @param string $method
     * @param string $url
     * @param array<string,string> $headers
     * @param array|null $body
     * @param int $timeout
     * @return array
     * @throws Throwable
     */
    public function request(string $method, string $url, array $headers = [], ?array $body = null, int $timeout = 30):array
    {
        $headers["Authorization"] = $this->tokens->getToken()->asAuthorizationHeader();
        return $this->inner->request($method,$url,$headers,$body,$timeout);
    }
}
