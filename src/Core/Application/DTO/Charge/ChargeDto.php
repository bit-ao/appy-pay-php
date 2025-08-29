<?php


namespace Bit\AppyPay\Core\Application\Dto\Charge;


use Bit\AppyPay\Core\Application\Dto\Reference\ReferenceDto;
use Exception;

final class ChargeDto
{
    public function __construct(
        public string $id,
        public string $merchantTransactionId,
        public string $type,
        public string $operation,
        public float $amount,
        public string $currency,
        public string $status,
        public string $description,
        public bool $disputes,
        public float $applicationFeeAmount,
        public string $paymentMethod,
        public string $createdDate,
        public string $updatedDate,
        public ?array $options = [],
        public ?ReferenceDto $reference  = null
    ) { }

    /** @param array<string,mixed> $data
     * @throws Exception
     */
    public static function fromArray(array $data): self
    {
        if ($data['reference']){
            $data['reference'] = ReferenceDto::fromArray($data['reference']);
        }
        return new self(
            id: $data['id'],
            merchantTransactionId:  $data['merchantTransactionId'],
            type:   $data['type'],
            operation:  $data['operation'],
            amount: $data['amount'],
            currency:   $data['currency'],
            status: $data['status'],
            description:    $data['description'],
            disputes:   $data['disputes'],
            applicationFeeAmount:   $data['applicationFeeAmount'],
            paymentMethod:  $data['paymentMethod'],
            createdDate:    $data['createdDate'],
            updatedDate:    $data['updatedDate'],
            options :   $data['options'],
            reference : $data['reference']
        );
    }
}
