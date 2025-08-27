<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Entities;

use Bit\AppyPay\Core\Domain\ValueObjects\Money;
use Bit\AppyPay\Core\Domain\ValueObjects\PaymentStatus;

final class Payment
{
    public function __construct(
        public readonly string $id,
        public readonly Money $amount,
        public readonly PaymentStatus $status,
        public readonly ?string $reference = null,
        public readonly ?array $raw = null
    ) {}
}
