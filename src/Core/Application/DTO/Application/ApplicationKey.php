<?php


namespace Bit\AppyPay\Core\Application\Dto\Application;

final class ApplicationKey
{
    public function __construct(
        public string $apiKey,
        public ?string $webHookName,
        public ?string $webHookDescription,
        public ?string $webHookUrl,
        public bool $isActive,
        public bool $isTransactional,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        $desc = $data['webHookDescription'] ?? $data['webHookdescription'] ?? null;

        return new self(
            apiKey: (string) ($data['apiKey'] ?? ''),
            webHookName: isset($data['webHookName']) ? (string) $data['webHookName'] : null,
            webHookDescription: isset($desc) ? (string) $desc : null,
            webHookUrl: isset($data['webHookUrl']) ? (string) $data['webHookUrl'] : null,
            isActive: (bool) ($data['isActive'] ?? false),
            isTransactional: (bool) ($data['isTransactional'] ?? false),
        );
    }
}