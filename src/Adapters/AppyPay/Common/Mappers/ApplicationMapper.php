<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Application;

final class ApplicationMapper
{
    public static function fromArray(array $d): Application
    {
        return new Application(
            id: (string)($d['id'] ?? $d['app_id'] ?? ''),
            name: (string)($d['name'] ?? ''),
            credentials: isset($d['credentials']) && is_array($d['credentials']) ? $d['credentials'] : null,
            raw: $d,

        );
    }
}
