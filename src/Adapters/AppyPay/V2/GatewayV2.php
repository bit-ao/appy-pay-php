<?php
declare(strict_types=1);
namespace Bit\AppyPay\Adapters\AppyPay\V2;
use Bit\AppyPay\Core\Contracts\ApplicationPortInterface;
use Bit\AppyPay\Core\Contracts\PaymentGatewayPortInterface;

final class GatewayV2 implements PaymentGatewayPortInterface
{
    public function __construct(
        private  ApplicationPortInterface $application,
    ) {}

    public function Application(): ApplicationPortInterface { return $this->application; }
}
