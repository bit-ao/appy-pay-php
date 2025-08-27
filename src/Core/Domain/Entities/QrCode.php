<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Entities;

final class QrCode
{
    public function __construct(
        public readonly string $id,
        public readonly bool $static,
        public readonly string $payload,
        public readonly ?array $raw = null
    ) {}
}
