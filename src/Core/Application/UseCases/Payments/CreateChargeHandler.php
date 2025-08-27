<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\UseCases\Payments;

use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeOutput;
use Bit\AppyPay\Core\Contracts\PaymentGatewayPort;

final class CreateChargeHandler implements CreateChargeUseCase
{
    public function __construct(private readonly PaymentGatewayPort $gateway) {}

    public function __invoke(CreateChargeInput $input): CreateChargeOutput
    {
        return $this->gateway->createCharge($input);
    }
}
