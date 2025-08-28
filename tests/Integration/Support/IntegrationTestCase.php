<?php
declare(strict_types=1);

namespace Tests\Integration\Support;
use Bit\AppyPay\Adapters\Auth\DiskTokenStorage;
use PHPUnit\Framework\TestCase;
use Bit\AppyPay\Adapters\AppyPay\GatewayFactory;
use Bit\AppyPay\Adapters\Auth\OAuthCredentials;
use Bit\AppyPay\Core\Contracts\PaymentGatewayPortInterface;

abstract class IntegrationTestCase extends TestCase
{
    protected static ?PaymentGatewayPortInterface $gateway = null;

    public static function setUpBeforeClass(): void
    {
        $apiBase      = getenv('APP_API_BASE_URL') ?: '';
        $authBase     = getenv('APP_AUTH_BASE_URL') ?: '';
        $clientId     = getenv('APP_CLIENT_ID') ?: '';
        $clientSecret = getenv('APP_CLIENT_SECRET') ?: '';
        $resource     = getenv('APP_RESOURCE') ?: '';

        $creds = new OAuthCredentials(
            clientId: $clientId,
            clientSecret: $clientSecret,
            resource: $resource
        );

        self::$gateway = GatewayFactory::make(
            version: 'v2.0',
            apiBaseUrl: $apiBase,
            authBaseUrl: $authBase,
            creds: $creds,
            storage: DiskTokenStorage::fromProjectTemp()
        );
    }
}
