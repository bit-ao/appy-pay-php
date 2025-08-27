<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\UseCases\Payments;

use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeOutput;

interface CreateChargeUseCase
{
    public function __invoke(CreateChargeInput $input): CreateChargeOutput;
}
