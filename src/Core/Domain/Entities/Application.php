<?php
declare(strict_types=1);

namespace Bit\AppyPay\Core\Domain\Entities;

final class Application
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $status = null,
    ) {}

    public static function fromArray(array $row): self
    {
        return new self(
            id:    (string)($row['id'] ?? ''),
            name:  (string)($row['name'] ?? ''),
            status: isset($row['status']) ? (string)$row['status'] : null,
        );
    }
}
