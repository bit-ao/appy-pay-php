<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\Payments;

use Bit\AppyPay\Core\Domain\Entities\Payment;

final class CreateChargeOutput
{
    public function __construct(
        public readonly Payment $payment
    ) {}
}
