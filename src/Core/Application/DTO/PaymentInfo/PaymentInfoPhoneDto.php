<?php


namespace Bit\AppyPay\Core\Application\Dto\PaymentInfo;


use Bit\AppyPay\Core\Contracts\PaymentInfoInterface;
use JetBrains\PhpStorm\ArrayShape;

class PaymentInfoPhoneDto implements PaymentInfoInterface
{
    public function __construct(
        public string $phoneNumber
    ){}
    /**
     * @return array
     */
    #[ArrayShape(['phoneNumber' => "string"])] public function toArray(): array
    {
        return [
            'phoneNumber'=>$this->phoneNumber
        ];
    }
}