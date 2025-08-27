<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Entities;

final class Reference
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $number = null,
        public readonly ?string $dueDate = null,
        public readonly ?array $raw = null
    ) {}
}
