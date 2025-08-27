<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\SddCreditor;

final class CreateCreditorAppInput
{
    public function __construct(
        public readonly string $companyName,
        public readonly string $nif,
        public readonly string $bank,
        public readonly ?array $metadata = null
    ) {}
}
