<?php


namespace Bit\AppyPay\Core\Application\Dto\PaymentInfo;


use Bit\AppyPay\Core\Contracts\PaymentInfoInterface;

class PaymentInfoPosDto implements PaymentInfoInterface
{
    public function __construct(
        public string $posCode
    ){}
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'posCode'=>$this->posCode
        ];
    }
}