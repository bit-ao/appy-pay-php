<?php


namespace Bit\AppyPay\Adapters\Auth;


use Bit\AppyPay\Core\Domain\ValueObjects\AccessToken;

final class MemoryTokenStorage implements TokenStoragePort {
    private ?AccessToken $t = null;
    public function get(): ?AccessToken { return $this->t; }
    public function set(AccessToken $t): void { $this->t = $t; }
    public function clear(): void { $this->t = null; }
}