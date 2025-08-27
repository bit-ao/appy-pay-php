<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay;

use Bit\AppyPay\Core\Contracts\PaymentGatewayPort;
use Bit\AppyPay\Adapters\AppyPay\V1\Gateway as GatewayV1;
use Bit\AppyPay\Adapters\AppyPay\V2\Gateway as GatewayV2;
use Bit\AppyPay\Adapters\Http\CurlHttpClient;
use InvalidArgumentException;

final class GatewayFactory
{
    public static function make(string $version, string $baseUrl, string $apiKey, ?string $apiSecret = null): PaymentGatewayPort
    {
        $v = strtolower($version);
        $http = new CurlHttpClient(rtrim($baseUrl, '/').'/'.$v);
        return match ($v) {
            'v1' => new GatewayV1($http, $apiKey, $apiSecret),
            'v2' => new GatewayV2($http, $apiKey, $apiSecret),
            default => throw new InvalidArgumentException("Versão não suportada: {$version}"),
        };
    }
}
