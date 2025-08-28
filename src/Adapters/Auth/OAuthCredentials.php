<?php

namespace Bit\AppyPay\Adapters\Auth;
final class OAuthCredentials {
    public function __construct(
        public  string $clientId,
        public  string $clientSecret,
        public  string $resource,
    ) {}
}