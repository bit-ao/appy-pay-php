<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\References;

use Bit\AppyPay\Core\Domain\ValueObjects\Money;

final class CreateReferenceInput
{
    public function __construct(
        public readonly Money $amount,
        public readonly ?\DateTimeImmutable $dueDate = null,
        public readonly ?string $description = null,
        public readonly ?array $metadata = null
    ) {}
}
