<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\Qr;

final class CreateQrCodeInput
{
    public function __construct(
        public readonly bool $static,
        public readonly array $payload, // depende do método, link ou EMVCo
        public readonly ?array $metadata = null
    ) {}
}
