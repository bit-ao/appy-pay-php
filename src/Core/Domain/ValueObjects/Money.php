<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\ValueObjects;

final class Money
{
    public function __construct(
        public readonly string $currency,
        public readonly int $amountMinor
    ) {}

    public static function aoaInt(int $kz): self
    {
        return new self('AOA', $kz);
    }
}
