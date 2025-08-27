<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Balance;

final class BalanceMapper
{
    public static function fromArray(array $d): Balance
    {
        return new Balance(
            accountId: (string)($d['accountId'] ?? $d['account_id'] ?? ''),
            amountMinor: isset($d['amount']) && is_array($d['amount']) ? (int) round(((float)($d['amount']['value'] ?? 0))*100) : (int)($d['amount'] ?? 0),
            currency: (string)($d['currency'] ?? 'AOA'),
            raw: $d,

        );
    }
}
