<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\Applications;
use Bit\AppyPay\Core\Domain\ValueObjects\PaymentMethod;
final class ApplicationAllInput
{
    public function __construct(
        public readonly PaymentMethod $paymentMethod = PaymentMethod::GPO,
        public readonly ?bool $isActive = null,
        public readonly ?bool $isDefault = null,
        public readonly ?bool $isEnabled = null,
        public readonly ?int $limit = 50,
        public readonly ?int $skip = 0
    ) {}
}
