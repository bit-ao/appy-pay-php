<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Application\DTO\SddCreditor\CreateCreditorAppInput;
use Bit\AppyPay\Core\Domain\Entities\CreditorApplication;

interface SddCreditorAppsPort
{
    public function apply(CreateCreditorAppInput $input): CreditorApplication;
    public function getStatus(string $id): CreditorApplication;
}
