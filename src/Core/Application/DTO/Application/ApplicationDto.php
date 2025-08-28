<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\Dto\Application;
use Exception;

final class ApplicationDto
{
    /** @var list<ApplicationKey> */
    public array $applicationKeys;

    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public string $paymentMethod,
        public bool $isDefault,
        public bool $isActive,
        public bool $isEnabled,
        public ?string $createdBy,
        public ?string $updatedBy,
        public string $createdDate,
        public ?string $updatedDate,
        array $applicationKeys
    ) {
        $this->applicationKeys = $applicationKeys;
    }

    /** @param array<string,mixed> $data
     * @throws Exception
     */
    public static function fromArray(array $data): self
    {
        $keysRaw = $data['applicationKeys'] ?? $data['applicationKyes'] ?? [];
        $keys = [];
        foreach ($keysRaw as $k) {
            if (is_array($k)) {
                $keys[] = ApplicationKey::fromArray($k);
            }
        }
        return new self(
            id:  $data['id'] ?? '',
            name:$data['name'] ?? '',
            description:$data['name'],
            paymentMethod:$data['paymentMethod'],
            isDefault:$data['isDefault'] ?? false,
            isActive:$data['isActive']  ??    false,
            isEnabled:$data['isEnabled']    ??  false,
            createdBy:$data['createdBy'],
            updatedBy:$data['updatedBy'] ?? null,
            createdDate:$data['createdDate'],
            updatedDate:$data['updatedDate'] ?? null,
            applicationKeys:$keys
        );
    }
}
