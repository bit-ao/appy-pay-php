<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

interface WebhookVerifierPort
{
    public function verify(string $payload, string $signatureHeader, string $secret): bool;
}
