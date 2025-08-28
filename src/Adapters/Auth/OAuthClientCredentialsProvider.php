<?php


namespace Bit\AppyPay\Adapters\Auth;

use Bit\AppyPay\Adapters\Http\HttpClient;
use Bit\AppyPay\Core\Contracts\TokenProviderPort;
use Bit\AppyPay\Core\Domain\ValueObjects\AccessToken;

final class OAuthClientCredentialsProvider implements TokenProviderPort {
    public function __construct(
        private  HttpClient $http,
        private  OAuthCredentials $creds,
        private  TokenStoragePort $store,
    ) {}

    public function getToken(): AccessToken
    {
        $cached = $this->store->get();
        if ($cached && !$cached->isExpired()) return $cached;

        $headers =  ['Content-Type' => 'application/x-www-form-urlencoded'];
        $body = [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->creds->clientId,
            'client_secret' => $this->creds->clientSecret,
            'resource' =>$this->creds->resource
        ];
        $resp = $this->http->request('POST', "", $headers, $body);
        $access = AccessToken::fromArray($resp);
        $this->store->set($access);
        return $access;
    }


    public function forceRefresh(): AccessToken
    {
        $this->store->clear();
        return $this->getToken();
    }
}