<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Entities;

final class Balance
{
    public function __construct(
        public readonly string $accountId,
        public readonly int $amountMinor,
        public readonly string $currency = 'AOA',
        public readonly ?array $raw = null
    ) {}
}
