<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Services;

use Bit\AppyPay\Core\Domain\ValueObjects\PaymentMethod;

final class PaymentMethodRules
{
    /** Se o método suporta criar cobrança */
    public static function supportsCharges(PaymentMethod $m): bool
    {
        return match ($m) {
            PaymentMethod::FTBAI => false,
            default => true
        };
    }

    /** Se o método suporta refund */
    public static function supportsRefunds(PaymentMethod $m): bool
    {
        return match ($m) {
            PaymentMethod::UMM, PaymentMethod::GPO, PaymentMethod::eTPA, PaymentMethod::SDD => true,
            default => false,
        };
    }

    /** Se o método suporta reverses */
    public static function supportsReverses(PaymentMethod $m): bool
    {
        return match ($m) {
            PaymentMethod::UMM => true,
            default => false,
        };
    }

    /** Se o método suporta reference generation/usage */
    public static function supportsReferences(PaymentMethod $m): bool
    {
        return $m === PaymentMethod::REF;
    }

    /** Se o método suporta funds transfers */
    public static function supportsFundsTransfers(PaymentMethod $m): bool
    {
        return $m === PaymentMethod::FTBAI;
    }

    /** Se o método suporta cancelamento */
    public static function supportsCancellation(PaymentMethod $m): bool
    {
        return $m === PaymentMethod::SDD;
    }

    /** Valor mínimo de cobrança em AOA (minor units). null = sem mínimo */
    public static function minAmount(PaymentMethod $m): ?int
    {
        return match ($m) {
            PaymentMethod::UMM => 50,          // 50 AOA
            PaymentMethod::GPO, PaymentMethod::eTPA => 1, // 1 AOA
            default => null,
        };
    }

    /** Tempo típico de aprovação (segundos) */
    public static function approvalTimeSeconds(PaymentMethod $m): ?int
    {
        return match ($m) {
            PaymentMethod::UMM => 30,
            PaymentMethod::FTBAI => 300,
            PaymentMethod::GPO, PaymentMethod::eTPA => 90,
            PaymentMethod::SDD => 10 * 24 * 60 * 60, // 10 dias
            default => null,
        };
    }

    /** Se aceita data de expiração */
    public static function allowsExpiration(PaymentMethod $m): bool
    {
        return $m === PaymentMethod::REF;
    }

    /** Expiração padrão (em horas) quando aceita expiração e não for passada explicitamente */
    public static function defaultExpireHours(PaymentMethod $m): ?int
    {
        return $m === PaymentMethod::REF ? 72 : null;
    }

    /** Comprimento permitido para número de referência (quando aplicável) */
    public static function referenceLengthRange(PaymentMethod $m): ?array
    {
        return $m === PaymentMethod::REF ? [9, 15] : null;
    }

    /** Política de webhook: 'always' | 'async_only' | 'none' */
    public static function webhookPolicy(PaymentMethod $m): string
    {
        return match ($m) {
            PaymentMethod::REF => 'always',
            PaymentMethod::UMM, PaymentMethod::GPO, PaymentMethod::eTPA, PaymentMethod::SDD => 'async_only',
            default => 'none',
        };
    }
}
