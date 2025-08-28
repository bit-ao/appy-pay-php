<?php

declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay;
use Bit\AppyPay\Adapters\AppyPay\Common\Adapters\ApplicationAdapter;
use Bit\AppyPay\Adapters\AppyPay\V2\GatewayV2;
use Bit\AppyPay\Adapters\Auth\OAuthClientCredentialsProvider;
use Bit\AppyPay\Adapters\Auth\OAuthCredentials;
use Bit\AppyPay\Adapters\Auth\TokenStoragePort;
use Bit\AppyPay\Adapters\Http\AuthenticatedHttpClient;
use Bit\AppyPay\Adapters\Http\GuzzleHttpClient;
use Bit\AppyPay\Core\Contracts\PaymentGatewayPortInterface;


final class GatewayFactory
{
    public static function make(
        string $version,
        string $apiBaseUrl,
        string $authBaseUrl,
        OAuthCredentials $creds,
        TokenStoragePort $storage
    ): PaymentGatewayPortInterface {
        $api  = new GuzzleHttpClient(rtrim($apiBaseUrl,'/') . '/' . strtolower($version));
        $auth = new GuzzleHttpClient(rtrim($authBaseUrl,'/'));
        $provider = new OAuthClientCredentialsProvider($auth, $creds, $storage);
        $authed   = new AuthenticatedHttpClient($api, $provider);
        if (strtolower($version) == 'v2.0'){
            return new GatewayV2(
                application:new ApplicationAdapter($authed)
            );
        }
        throw new \InvalidArgumentException("Versão não suportada: {$version}");
    }
}
