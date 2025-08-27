<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\ValueObjects;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PAID    = 'paid';
    case FAILED  = 'failed';
    case CANCELED= 'canceled';
}
