<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Entities;

final class Account
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name = null,
        public readonly ?array $raw = null
    ) {}
}
