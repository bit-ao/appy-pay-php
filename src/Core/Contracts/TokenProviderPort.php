<?php

namespace Bit\AppyPay\Core\Contracts;
use Bit\AppyPay\Core\Domain\ValueObjects\AccessToken;

interface TokenProviderPort {
    public function getToken(): AccessToken; // entrega token fresco (renova se preciso)
}