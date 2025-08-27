<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Refund;

final class RefundMapper
{
    public static function fromArray(array $d): Refund
    {
        return new Refund(
            id: (string)($d['id'] ?? $d['refund_id'] ?? ''),
            chargeId: (string)($d['chargeId'] ?? $d['charge_id'] ?? ''),
            amountMinor: isset($d['amount']) && is_array($d['amount']) ? (int) round(((float)($d['amount']['value'] ?? 0))*100) : (int)($d['amount'] ?? 0),
            status: $d['status'] ?? null,
            raw: $d,

        );
    }
}
