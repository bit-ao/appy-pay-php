<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Services;

use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Domain\ValueObjects\PaymentMethod;
use InvalidArgumentException;

final class ChargeRequestValidator
{
    public static function validate(CreateChargeInput $in): void
    {
        // Método permitido para charge?
        if (!PaymentMethodRules::supportsCharges($in->method)) {
            throw new InvalidArgumentException("Método {$in->method->value} não suporta criação de cobranças.");
        }

        // Mínimo
        $min = PaymentMethodRules::minAmount($in->method);
        if ($min !== null && $in->amount->amountMinor < $min) {
            throw new InvalidArgumentException("Valor mínimo para {$in->method->value} é {$min} AOA.");
        }

        // Webhook obrigatório (REF)
        $policy = PaymentMethodRules::webhookPolicy($in->method);
        if ($policy === 'always' && empty($in->callbackUrl)) {
            throw new InvalidArgumentException("{$in->method->value} requer callbackUrl (webhook) obrigatório.");
        }

        // Expiração (REF)
        if (PaymentMethodRules::allowsExpiration($in->method)) {
            // se não passar, a API aplica default (72h); não obrigatório validar
            // mas podemos validar se passado (coerência temporal).
            if ($in->options?->expiresAt && $in->options->expiresAt < new \DateTimeImmutable('now')) {
                throw new InvalidArgumentException("expiresAt não pode ser no passado.");
            }
        }
    }
}
