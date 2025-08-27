<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\Payments;

use DateTimeImmutable;

final class CreateChargeOptions
{
    public function __construct(
        public readonly ?string $channel = null,             // 'qr', 'reference', 'link', etc.
        public readonly ?string $payerDocument = null,       // BI/NIF/phone, se aplicável
        public readonly ?string $account = null,             // UMM: msisdn/conta (quando aplicável)
        public readonly ?DateTimeImmutable $expiresAt = null,// REF: data de expiração
        public readonly array $vendor = []                   // vendor-specific bag (appypay_v2, etc.)
    ) {}
}
