<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\Applications\ApplicationAllInput;
use Bit\AppyPay\Core\Application\DTO\Applications\ApplicationOneInput;
use Bit\AppyPay\Core\Application\DTO\Applications\ApplicationsOutput;
use Bit\AppyPay\Core\Domain\Entities\Application;

interface ApplicationsPort
{
    public function applicationAll(ApplicationAllInput $input ): ApplicationsOutput;
    public function applicationOne(string $id, ApplicationOneInput $input ): Application;
}


