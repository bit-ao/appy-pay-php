<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Account;

final class AccountMapper
{
    public static function fromArray(array $d): Account
    {
        return new Account(
            id: (string)($d['id'] ?? $d['account_id'] ?? ''),
            name: $d['name'] ?? null,
            raw: $d,

        );
    }
}
