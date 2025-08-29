<?php

declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\Dto\Application\ApplicationDto;
use Bit\AppyPay\Core\Application\Dto\Application\ApplicationListInput;
use Bit\AppyPay\Core\Application\Dto\Application\ApplicationListOutput;

/**
 * Interface ApplicationPort
 * @package Bit\AppyPay\Core\Contracts
 */
interface ApplicationPortInterface
{
    /**
     * @param ApplicationListInput $input
     * @return ApplicationListOutput
     */
    public function list(ApplicationListInput $input): ApplicationListOutput;

    /**
     * @param string $applicationId
     * @return ApplicationDto
     */
    public function get(string $applicationId): ApplicationDto;
}
