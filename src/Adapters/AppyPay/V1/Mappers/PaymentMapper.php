<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\V1\Mappers;

use Bit\AppyPay\Core\Domain\Entities\Payment;
use Bit\AppyPay\Core\Domain\ValueObjects\Money;
use Bit\AppyPay\Core\Domain\ValueObjects\PaymentStatus;

final class PaymentMapper
{
    public static function fromArray(array $data): Payment
    {
        return new Payment(
            id: (string)($data['id'] ?? $data['payment_id'] ?? ''),
            amount: new Money(
                currency: (string)($data['currency'] ?? 'AOA'),
                amountMinor: (int)($data['amount'] ?? 0),
            ),
            status: PaymentStatus::from((string)($data['status'] ?? 'pending')),
            reference: $data['reference'] ?? null,
            raw: $data
        );
    }
}
