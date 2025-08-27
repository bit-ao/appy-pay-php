<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\V2\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Payment;
use Bit\AppyPay\Core\Domain\ValueObjects\Money;
use Bit\AppyPay\Core\Domain\ValueObjects\PaymentStatus;

final class PaymentMapper
{
    public static function fromArray(array $data): Payment
    {
        // Exemplo: V2 pode devolver amount como objeto { value: "150.00", currency: "AOA" }
        $amountMinor = 0;
        $currency = 'AOA';
        if (isset($data['amount']) && is_array($data['amount'])) {
            $currency = (string)($data['amount']['currency'] ?? 'AOA');
            $value = (float)($data['amount']['value'] ?? 0);
            $amountMinor = (int) round($value * 100);
        } else {
            $currency = (string)($data['currency'] ?? 'AOA');
            $amountMinor = (int)($data['amount'] ?? 0);
        }

        return new Payment(
            id: (string)($data['id'] ?? $data['payment_id'] ?? ''),
            amount: new Money(currency: $currency, amountMinor: $amountMinor),
            status: PaymentStatus::from((string)($data['status'] ?? 'pending')),
            reference: $data['reference'] ?? null,
            raw: $data
        );
    }
}
