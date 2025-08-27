<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\Funds;

use Bit\AppyPay\Core\Domain\ValueObjects\Money;

final class CreateTransferInput
{
    public function __construct(
        public readonly string $sourceAccount,
        public readonly string $destinationAccount,
        public readonly Money $amount,
        public readonly ?string $memo = null,
        public readonly ?array $metadata = null
    ) {}
}
