<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Transfer;

final class TransferMapper
{
    public static function fromArray(array $d): Transfer
    {
        return new Transfer(
            id: (string)($d['id'] ?? $d['transfer_id'] ?? ''),
            sourceAccount: (string)($d['sourceAccount'] ?? $d['source_account'] ?? ''),
            destinationAccount: (string)($d['destinationAccount'] ?? $d['destination_account'] ?? ''),
            amountMinor: isset($d['amount']) && is_array($d['amount']) ? (int) round(((float)($d['amount']['value'] ?? 0))*100) : (int)($d['amount'] ?? 0),
            status: $d['status'] ?? null,
            raw: $d,

        );
    }
}
