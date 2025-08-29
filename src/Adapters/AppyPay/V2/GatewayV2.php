<?php
declare(strict_types=1);
namespace Bit\AppyPay\Adapters\AppyPay\V2;
use Bit\AppyPay\Core\Contracts\ApplicationPortInterface;
use Bit\AppyPay\Core\Contracts\PaymentGatewayPortInterface;
use Bit\AppyPay\Core\Contracts\ChargePortInterface;

final class GatewayV2 implements PaymentGatewayPortInterface
{
    public function __construct(
        private  ApplicationPortInterface $application,
        private  ChargePortInterface $charge
    ) {}

    public function application(): ApplicationPortInterface { return $this->application; }
    public function charge(): ChargePortInterface { return $this->charge; }
}
