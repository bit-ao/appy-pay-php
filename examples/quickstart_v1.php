<?php
require __DIR__ . '/../vendor/autoload.php';

use Bit\AppyPay\Adapters\AppyPay\GatewayFactory;
use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Domain\ValueObjects\Money;

$gateway = GatewayFactory::make('v1', 'https://api.appypay.ao', 'KEY_AQUI');

$input = new CreateChargeInput(
    amount: Money::aoaInt(15000),
    reference: 'PEDIDO-12345',
    description: 'Compra #12345',
    callbackUrl: 'https://teusistema.ao/webhooks/appypay',
    returnUrl: 'https://teusistema.ao/sucesso/12345'
);

$out = $gateway->createCharge($input);
print_r($out->payment);
