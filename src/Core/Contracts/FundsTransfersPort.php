<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\Funds\CreateTransferInput;
use Bit\AppyPay\Core\Domain\Entities\Transfer;

interface FundsTransfersPort
{
    public function createTransfer(CreateTransferInput $input): Transfer;
    public function getTransfer(string $id): Transfer;
}
