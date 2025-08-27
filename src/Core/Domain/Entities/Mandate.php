<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Entities;

final class Mandate
{
    public function __construct(
        public readonly string $id,
        public readonly string $debtorAccount,
        public readonly string $creditorId,
        public readonly ?string $status = null,
        public readonly ?array $raw = null
    ) {}
}
