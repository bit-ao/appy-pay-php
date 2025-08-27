<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Reference;

final class ReferenceMapper
{
    public static function fromArray(array $d): Reference
    {
        return new Reference(
            id: (string)($d['id'] ?? $d['reference_id'] ?? ''),
            number: $d['number'] ?? ($d['reference'] ?? null),
            dueDate: $d['dueDate'] ?? $d['due_date'] ?? null,
            raw: $d,

        );
    }
}
