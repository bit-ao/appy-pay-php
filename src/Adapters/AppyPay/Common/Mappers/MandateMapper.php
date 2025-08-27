<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Mandate;

final class MandateMapper
{
    public static function fromArray(array $d): Mandate
    {
        return new Mandate(
            id: (string)($d['id'] ?? $d['mandate_id'] ?? ''),
            debtorAccount: (string)($d['debtorAccount'] ?? $d['debtor_account'] ?? ''),
            creditorId: (string)($d['creditorId'] ?? $d['creditor_id'] ?? ''),
            status: $d['status'] ?? null,
            raw: $d,

        );
    }
}
