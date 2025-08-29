<?php
namespace Bit\AppyPay\Core\Contracts;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeCreateInput;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeDto;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeListInput;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeListOutput;

interface ChargePortInterface
{
    public function list(ChargeListInput $input): ChargeListOutput;
    public function get(string $chargeId): ChargeDto;
    public function create(ChargeCreateInput $input): ChargeDto;
}