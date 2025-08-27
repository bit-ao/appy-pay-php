<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\DTO\Reverses;

final class CreateReverseInput
{
    public function __construct(
        public readonly string $chargeId,
        public readonly ?string $reason = null,
        public readonly ?array $metadata = null
    ) {}
}
