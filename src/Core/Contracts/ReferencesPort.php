<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\References\CreateReferenceInput;
use Bit\AppyPay\Core\Domain\Entities\Reference;

interface ReferencesPort
{
    public function createReference(CreateReferenceInput $input): Reference;
    public function getReference(string $id): Reference;
}
