<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Entities;

final class Refund
{
    public function __construct(
        public readonly string $id,
        public readonly string $chargeId,
        public readonly ?int $amountMinor = null,
        public readonly ?string $status = null,
        public readonly ?array $raw = null
    ) {}
}
