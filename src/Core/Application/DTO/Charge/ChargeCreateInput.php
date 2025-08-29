<?php


namespace Bit\AppyPay\Core\Application\Dto\Charge;


use Bit\AppyPay\Core\Application\Dto\Notify\NotifyDto;
use Bit\AppyPay\Core\Contracts\PaymentInfoInterface;

class ChargeCreateInput
{

    public function __construct(
        public string $merchantTransactionId ,
        public string $paymentMethod,
        public PaymentInfoInterface $paymentInfo ,
        public float $amount = 1,
        public string $currency = "AOA",
        public ?NotifyDto $notify = null ,
    ) {}
    public function toArray():array{
        $query = [
            'merchantTransactionId'      => $this->merchantTransactionId,
            'paymentMethod'              => $this->paymentMethod,
            'paymentInfo'                => $this->paymentInfo->toArray(),
            'currency'                   => $this->currency,
            'amount'                     => $this->amount,
            'notify'                     => $this->notify != null ? $this->notify->toArray() : null
        ];
        return array_filter($query, static fn ($v) => $v !== null && $v !== '');
    }
}