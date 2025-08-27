<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\Reverses\CreateReverseInput;
use Bit\AppyPay\Core\Domain\Entities\Reverse;

interface ReversesPort
{
    public function createReverse(CreateReverseInput $input): Reverse;
}
