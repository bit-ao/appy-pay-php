<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\DirectDebit\CreateMandateInput;
use Bit\AppyPay\Core\Domain\Entities\Mandate;

interface DirectDebitPort
{
    public function createMandate(CreateMandateInput $input): Mandate;
    public function getMandate(string $id): Mandate;
    public function revokeMandate(string $id): void;
}
