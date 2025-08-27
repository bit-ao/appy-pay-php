<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeOutput;
use Bit\AppyPay\Core\Domain\Entities\Payment;

interface PaymentGatewayPort
{
    public function createCharge(CreateChargeInput $input): CreateChargeOutput;

    /** @return Payment */
    public function getCharge(string $id);
}
