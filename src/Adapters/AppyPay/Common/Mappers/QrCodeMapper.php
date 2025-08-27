<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Domain\Entities\QrCode;

final class QrCodeMapper
{
    public static function fromArray(array $d): QrCode
    {
        return new QrCode(
            id: (string)($d['id'] ?? $d['qrcode_id'] ?? ''),
            static: (bool)($d['static'] ?? false),
            payload: (string)($d['payload'] ?? ''),
            raw: $d,

        );
    }
}
