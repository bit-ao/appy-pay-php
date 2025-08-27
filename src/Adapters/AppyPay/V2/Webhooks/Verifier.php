<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\V2\Webhooks;

use Bit\AppyPay\Core\Contracts\WebhookVerifierPort;

final class Verifier implements WebhookVerifierPort
{
    public function __construct(private readonly string $algorithm = 'sha256') {}

    public function verify(string $payload, string $signatureHeader, string $secret): bool
    {
        if ($signatureHeader === '' || $secret === '') return false;
        $calc = hash_hmac($this->algorithm, $payload, $secret);
        return hash_equals($calc, trim($signatureHeader));
    }
}
