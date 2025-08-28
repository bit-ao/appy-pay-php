<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\ValueObjects;

final class AccessToken
{
    public function __construct(
        public string $tokenType,
        public string $extExpiresIn,
        public string $expiresOn,
        public string $notBefore,
        public string $resource,
        public string $accessToken
    ) {}

    /**
     * Verifica se o token já expirou.
     * @param int $skewSeconds margem de segurança para compensar “clock skew”.
     */
    public function isExpired(int $skewSeconds = 30): bool
    {
        $exp = $this->parseTime($this->expiresOn);
        if ($exp === null) {
            return true; // se não conseguirmos ler a expiração, tratamos como expirado
        }
        return time() >= ($exp - max(0, $skewSeconds));
    }

    /**
     * Verifica se o token já é válido (respeitando o notBefore).
     */
    public function isUsable(int $skewSeconds = 30): bool
    {
        $nbf = $this->parseTime($this->notBefore) ?? 0;
        return time() >= ($nbf - max(0, $skewSeconds)) && !$this->isExpired($skewSeconds);
    }

    /**
     * Segundos restantes até expirar (valor >= 0). Se não for possível calcular, retorna 0.
     */
    public function secondsUntilExpiration(int $skewSeconds = 0): int
    {
        $exp = $this->parseTime($this->expiresOn);
        if ($exp === null) {
            return 0;
        }
        return max(0, ($exp - $skewSeconds) - time());
    }

    /**
     * Cabeçalho Authorization pronto para enviar em requests.
     */
    public function asAuthorizationHeader(): string
    {
        return trim($this->tokenType) . ' ' . trim($this->accessToken);
    }

    /**
     * Data/hora de expiração como DateTimeImmutable (ou null se não puder interpretar).
     * @throws \Exception
     */
    public function expiresAt(): ?\DateTimeImmutable
    {
        $exp = $this->parseTime($this->expiresOn);
        return $exp !== null ? (new \DateTimeImmutable('@' . $exp))->setTimezone(new \DateTimeZone(date_default_timezone_get())) : null;
    }

    /**
     * Data/hora notBefore como DateTimeImmutable (ou null).
     */
    public function notBeforeAt(): ?\DateTimeImmutable
    {
        $nbf = $this->parseTime($this->notBefore);
        return $nbf !== null ? (new \DateTimeImmutable('@' . $nbf))->setTimezone(new \DateTimeZone(date_default_timezone_get())) : null;
    }

    /**
     * Factory a partir de payload (Azure AD costuma enviar tanto snake_case quanto camelCase).
     * Aceita 'expires_on' (epoch ou string parsável) ou 'expires_in' (segundos, será somado ao now()).
     */
    public static function fromArray(array $payload): self
    {
        $tokenType     = (string)($payload['token_type']    ?? $payload['tokenType']    ?? 'Bearer');
        $extExpiresIn  = (string)($payload['ext_expires_in']?? $payload['extExpiresIn'] ?? ($payload['expires_in'] ?? 0));
        $resource      = (string)($payload['resource']      ?? $payload['aud']          ?? '');
        $accessToken   = (string)($payload['access_token']  ?? $payload['accessToken']  ?? '');

        $expiresOn = (string)($payload['expires_on'] ?? $payload['expiresOn'] ?? '');
        if ($expiresOn === '' && isset($payload['expires_in'])) {
            $expiresOn = (string)(time() + (int)$payload['expires_in']);
        }

        $notBefore = (string)($payload['not_before'] ?? $payload['notBefore'] ?? (string)(time() - 30));

        return new self(
            tokenType:    $tokenType,
            extExpiresIn: $extExpiresIn,
            expiresOn:    $expiresOn,
            notBefore:    $notBefore,
            resource:     $resource,
            accessToken:  $accessToken
        );
    }

    /**
     * Tenta interpretar um tempo vindo como epoch (string/int) ou como data legível (ex: ISO8601).
     * Retorna epoch (int) ou null se não conseguir.
     */
    private function parseTime(string $value): ?int
    {
        $value = trim($value);
        if ($value === '') {
            return null;
        }

        // epoch (numérico)
        if (ctype_digit($value)) {
            return (int)$value;
        }

        // tentativa de parse genérico (ex: 2025-08-28T15:10:00Z)
        $ts = strtotime($value);
        return $ts !== false ? $ts : null;
    }
}
