<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\Payments;

use Bit\AppyPay\Core\Domain\ValueObjects\Money;
use Bit\AppyPay\Core\Domain\ValueObjects\PaymentMethod;

final class CreateChargeInput
{
    public function __construct(
        public readonly Money $amount,
        public readonly string $reference,
        public readonly PaymentMethod $method,
        public readonly ?string $description = null,
        public readonly ?string $callbackUrl = null,
        public readonly ?string $returnUrl = null,
        public readonly ?array  $customer = null,
        public readonly ?array  $metadata = null,
        public readonly ?CreateChargeOptions $options = null
    ) {}
}
