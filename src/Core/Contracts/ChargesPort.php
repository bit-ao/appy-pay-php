<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeOutput;
use Bit\AppyPay\Core\Domain\Entities\Payment;

interface ChargesPort
{
    public function createCharge(CreateChargeInput $input): CreateChargeOutput;
    public function getCharge(string $id): Payment;
}
