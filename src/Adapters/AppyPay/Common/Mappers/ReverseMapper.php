<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Reverse;

final class ReverseMapper
{
    public static function fromArray(array $d): Reverse
    {
        return new Reverse(
            id: (string)($d['id'] ?? $d['reverse_id'] ?? ''),
            chargeId: (string)($d['chargeId'] ?? $d['charge_id'] ?? ''),
            status: $d['status'] ?? null,
            raw: $d,

        );
    }
}
