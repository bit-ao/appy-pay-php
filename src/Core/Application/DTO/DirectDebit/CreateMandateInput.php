<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\DirectDebit;

final class CreateMandateInput
{
    public function __construct(
        public readonly string $debtorAccount,
        public readonly string $creditorId,
        public readonly ?string $scheme = null,
        public readonly ?array $metadata = null
    ) {}
}
