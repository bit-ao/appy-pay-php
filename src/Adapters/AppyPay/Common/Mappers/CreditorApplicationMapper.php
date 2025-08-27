<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\CreditorApplication;

final class CreditorApplicationMapper
{
    public static function fromArray(array $d): CreditorApplication
    {
        return new CreditorApplication(
            id: (string)($d['id'] ?? $d['application_id'] ?? ''),
            companyName: (string)($d['companyName'] ?? $d['company_name'] ?? ''),
            nif: (string)($d['nif'] ?? ''),
            bank: (string)($d['bank'] ?? ''),
            status: $d['status'] ?? null,
            raw: $d,

        );
    }
}
