<?php

namespace Bit\AppyPay\Core\Application\Dto\Reference;


final class ReferenceDto
{
    public function __construct(
        public string $referenceNumber,
        public string $dueDate,
        public string $entity,
    ) { }

    public static function fromArray(array $data): self
    {
        return new self(
            referenceNumber:  $data['referenceNumber'],
            dueDate:  $data['dueDate'],
            entity:  $data['entity'],
        );
    }
}
