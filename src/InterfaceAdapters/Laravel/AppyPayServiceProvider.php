<?php
declare(strict_types=1);

namespace Bit\AppyPay\InterfaceAdapters\Laravel;

use Illuminate\Support\ServiceProvider;
use Bit\AppyPay\Core\Contracts\PaymentGatewayPortInterface;
use Bit\AppyPay\Adapters\AppyPay\GatewayFactory;

final class AppyPayServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/appypay.php', 'appypay');

        $this->app->bind(PaymentGatewayPortInterface::class, function () {
            $cfg = config('appypay');
            return GatewayFactory::make(
                version:  $cfg['version']   ?? 'v1',
                baseUrl:  $cfg['base_url']  ?? 'https://api.appypay.ao',
                apiKey:   (string)$cfg['api_key'],
                apiSecret:$cfg['api_secret'] ?? null
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/config/appypay.php' => config_path('appypay.php'),
        ], 'config');
    }
}
