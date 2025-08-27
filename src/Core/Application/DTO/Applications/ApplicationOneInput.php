<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\Applications;
use Bit\AppyPay\Core\Domain\ValueObjects\PaymentMethod;
final class ApplicationOneInput
{
    public function __construct(
        public PaymentMethod $paymentMethod = PaymentMethod::GPO,
        public ?bool $isActive = null,
        public ?bool $isDefault = null,
        public ?bool $isEnabled = null,
        public ?int $limit = 50,
        public ?int $skip = 0
    ) {}
}
