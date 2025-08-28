<?php
require __DIR__ . '/../vendor/autoload.php';

use Bit\AppyPay\Adapters\AppyPay\GatewayFactory;
use Bit\AppyPay\Core\Application\Dto\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Domain\ValueObjects\Money;

$gateway = GatewayFactory::make('v2', 'https://api.appypay.ao', 'KEY_AQUI');

$input = new CreateChargeInput(
    amount: Money::aoaInt(1999),
    reference: 'PEDIDO-67890',
    description: 'Compra #67890'
);

$out = $gateway->createCharge($input);
print_r($out->payment);
