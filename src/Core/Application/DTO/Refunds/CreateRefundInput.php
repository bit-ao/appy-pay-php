<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\Refunds;

final class CreateRefundInput
{
    public function __construct(
        public readonly string $chargeId,
        public readonly ?int $amountMinor = null,
        public readonly ?string $reason = null,
        public readonly ?array $metadata = null
    ) {}
}
