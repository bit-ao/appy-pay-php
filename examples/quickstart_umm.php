<?php
require __DIR__ . '/../vendor/autoload.php';

use Bit\AppyPay\Adapters\AppyPay\GatewayFactory;
use Bit\AppyPay\Core\Application\Dto\Payments\{CreateChargeInput, CreateChargeOptions};
use Bit\AppyPay\Core\Domain\ValueObjects\{Money, PaymentMethod};

$gateway = GatewayFactory::make('v1', 'https://api.appypay.ao', 'KEY_AQUI');

$input = new CreateChargeInput(
    amount: Money::aoaInt(500), // mínimo 50 AOA para UMM; aqui 500 AOA
    reference: 'PEDIDO-UMM-001',
    method: PaymentMethod::UMM,
    description: 'Compra via Unitel Money',
    callbackUrl: 'https://teusistema.ao/webhooks/appypay',
    options: new CreateChargeOptions(
        account: '2449xxxxxxx' // MSISDN/conta do cliente (se aplicável)
    )
);

$out = $gateway->createCharge($input);
print_r($out->payment);
