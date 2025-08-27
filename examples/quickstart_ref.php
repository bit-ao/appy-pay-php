<?php
require __DIR__ . '/../vendor/autoload.php';

use Bit\AppyPay\Adapters\AppyPay\GatewayFactory;
use Bit\AppyPay\Core\Application\DTO\Payments\{CreateChargeInput, CreateChargeOptions};
use Bit\AppyPay\Core\Domain\ValueObjects\{Money, PaymentMethod};

$gateway = GatewayFactory::make('v2', 'https://api.appypay.ao', 'KEY_AQUI');

$input = new CreateChargeInput(
    amount: Money::aoaInt(10000), // 10.000 AOA
    reference: 'PEDIDO-REF-001',
    method: PaymentMethod::REF,
    description: 'Fatura 2025-0001',
    callbackUrl: 'https://teusistema.ao/webhooks/appypay',
    options: new CreateChargeOptions(
        expiresAt: new DateTimeImmutable('+72 hours')
    )
);

$out = $gateway->createCharge($input);
print_r($out->payment);
