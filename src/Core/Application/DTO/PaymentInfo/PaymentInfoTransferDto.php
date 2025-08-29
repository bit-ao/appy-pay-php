<?php


namespace Bit\AppyPay\Core\Application\Dto\PaymentInfo;


use Bit\AppyPay\Core\Contracts\PaymentInfoInterface;

class PaymentInfoTransferDto implements PaymentInfoInterface
{

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}