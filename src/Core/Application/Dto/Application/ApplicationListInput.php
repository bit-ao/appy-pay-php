<?php

declare(strict_types=1);

namespace Bit\AppyPay\Core\Application\Dto\Application;

use JetBrains\PhpStorm\ArrayShape;

/**
 * Class ApplicationListInput
 * @package Bit\AppyPay\Core\ApplicationDto\Dto\ApplicationDto
 */
final class ApplicationListInput
{
    /**
     * ApplicationListInput constructor.
     * @param string|null $paymentMethod
     * @param bool|null $isActive
     * @param bool|null $isDefault
     * @param bool|null $isEnabled
     * @param int|null $limit
     * @param int|null $skip
     */
    public function __construct(
        public  ?string $paymentMethod = null,
        public  ?bool $isActive = null,
        public  ?bool $isDefault = null,
        public  ?bool $isEnabled = null,
        public  ?int $limit = 50,
        public  ?int $skip = 0
    ) {}

    /**
     * @return array
     */
    #[ArrayShape(["is_active" => "bool|null", "is_default" => "bool|null", "is_enabled" => "bool|null", "limit" => "int|null", "skip" => "int|null", "payment_method" => "mixed"])] public function toQuery():array{
        return [
            "is_active"=> $this->isActive,
            "is_default"=> $this->isDefault,
            "is_enabled"=> $this->isEnabled,
            "limit"=> $this->limit,
            "skip"=> $this->skip,
            "payment_method"=> $this->paymentMethod
        ];
    }
}
