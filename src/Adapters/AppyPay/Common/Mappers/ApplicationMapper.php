<?php
declare(strict_types=1);

namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;

use Bit\AppyPay\Core\Application\Dto\Application\ApplicationDto;
use Bit\AppyPay\Core\Application\Dto\Application\ApplicationPageOutput;
use Exception;

final class ApplicationMapper
{
    public static function list(array $d): ApplicationPageOutput
    {
        return new ApplicationPageOutput(
            totalCount:   (int)($d['totalCount'] ?? 0),
            hasMorePages: (bool)($d['hasMorePages'] ?? false),
            applications: array_map(function ($item){
            return self::one($item);
        }, (array)($d['applications'] ?? [])),
        );
    }

    /**
     * @throws Exception
     */
    public static function one(array $d): ApplicationDto
    {
        return ApplicationDto::fromArray($d);
    }
}
