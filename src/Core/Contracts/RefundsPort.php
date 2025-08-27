<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\Refunds\CreateRefundInput;
use Bit\AppyPay\Core\Domain\Entities\Refund;

interface RefundsPort
{
    public function createRefund(CreateRefundInput $input): Refund;
    public function getRefund(string $id): Refund;
}
