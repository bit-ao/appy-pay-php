<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\Auth;

use Bit\AppyPay\Core\Domain\ValueObjects\AccessToken;

final class DiskTokenStorage implements TokenStoragePort
{
    public function __construct(
        private string $path,
        private int $fileMode = 0600
    ) {
        $dir = \dirname($this->path);
        if (!is_dir($dir) && !@mkdir($dir, 0770, true) && !is_dir($dir)) {
            throw new \RuntimeException("Não foi possível criar o diretório: {$dir}");
        }
    }

    /** Conveniência: `temp/` na raiz do projeto */
    public static function fromProjectTemp(string $filename = 'oauth_token.json', int $fileMode = 0600): self
    {
        $root = self::findProjectRoot(__DIR__);
        $tempDir = $root . DIRECTORY_SEPARATOR . 'temp';
        if (!is_dir($tempDir) && !@mkdir($tempDir, 0770, true) && !is_dir($tempDir)) {
            throw new \RuntimeException("Não foi possível criar o diretório temp: {$tempDir}");
        }
        return new self($tempDir . DIRECTORY_SEPARATOR . $filename, $fileMode);
    }

    /** Procura `composer.json` a subir diretórios; fallback para 3 níveis acima */
    private static function findProjectRoot(string $startDir): string
    {
        $dir = $startDir;
        for ($i = 0; $i < 8; $i++) {
            if (is_file($dir . DIRECTORY_SEPARATOR . 'composer.json')) {
                return $dir;
            }
            $parent = \dirname($dir);
            if ($parent === $dir) break;
            $dir = $parent;
        }
        return \dirname($startDir, 3);
    }

    public function get(): ?AccessToken
    {
        if (!is_file($this->path)) {
            return null;
        }
        $fh = @fopen($this->path, 'rb');
        if ($fh === false) return null;

        try {
            @flock($fh, LOCK_SH);
            $json = stream_get_contents($fh);
        } finally {
            @flock($fh, LOCK_UN);
            @fclose($fh);
        }

        if ($json === false || $json === '') return null;

        $data = json_decode($json, true);
        if (!is_array($data)) {
            $this->clear();
            return null;
        }

        try {
            return AccessToken::fromArray($data);
        } catch (\Throwable) {
            $this->clear();
            return null;
        }
    }

    public function set(AccessToken $t): void
    {
        $payload = [
            'token_type'     => $t->tokenType,
            'ext_expires_in' => $t->extExpiresIn,
            'expires_on'     => $t->expiresOn,
            'not_before'     => $t->notBefore,
            'resource'       => $t->resource,
            'access_token'   => $t->accessToken,
        ];

        $json = json_encode($payload, JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            throw new \RuntimeException('Falha ao serializar token para JSON.');
        }

        $tmp = $this->path . '.' . bin2hex(random_bytes(6)) . '.tmp';
        $fh = @fopen($tmp, 'wb');
        if ($fh === false) throw new \RuntimeException("Não foi possível abrir temp: {$tmp}");

        try {
            @flock($fh, LOCK_EX);
            $written = fwrite($fh, $json);
            if ($written === false || $written < strlen($json)) {
                throw new \RuntimeException('Falha ao escrever token no disco.');
            }
            fflush($fh);
            if (function_exists('fsync')) { @fsync($fh); }
        } finally {
            @flock($fh, LOCK_UN);
            @fclose($fh);
        }

        @chmod($tmp, $this->fileMode);
        if (!@rename($tmp, $this->path)) {
            @unlink($tmp);
            throw new \RuntimeException("Não foi possível mover ficheiro temporário para {$this->path}");
        }
    }

    public function clear(): void
    {
        if (is_file($this->path)) {
            @unlink($this->path);
        }
    }
}
