<?php
namespace Bit\AppyPay\Core\Application\Dto\PaymentInfo;
use Bit\AppyPay\Core\Contracts\PaymentInfoInterface;
use JetBrains\PhpStorm\ArrayShape;

class PaymentInfoRefDto implements PaymentInfoInterface
{

    public function __construct(
        public ?string $referenceNumber = null,
        public ?string $dueDate = null
    ){}

    /**
     * @return array
     */
    #[ArrayShape(["referenceNumber" => "null|string", "dueDate" => "null|string"])] public function toArray(): array
    {
        return [
            "referenceNumber"=>$this->referenceNumber,
            "dueDate"=>$this->dueDate,
        ];
    }cg f2w
}