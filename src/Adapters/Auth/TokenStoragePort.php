<?php


namespace Bit\AppyPay\Adapters\Auth;


use Bit\AppyPay\Core\Domain\ValueObjects\AccessToken;

interface TokenStoragePort {
    public function get(): ?AccessToken;
    public function set(AccessToken $t): void;
    public function clear(): void;
}

