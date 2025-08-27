<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Contracts;

use Bit\AppyPay\Core\Domain\Entities\Account;
use Bit\AppyPay\Core\Domain\Entities\Balance;

interface AccountsPort
{
    public function getAccount(string $id): Account;
    public function getBalance(string $id): Balance;
}
