<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Entities;

final class CreditorApplication
{
    public function __construct(
        public readonly string $id,
        public readonly string $companyName,
        public readonly string $nif,
        public readonly string $bank,
        public readonly ?string $status = null,
        public readonly ?array $raw = null
    ) {}
}
