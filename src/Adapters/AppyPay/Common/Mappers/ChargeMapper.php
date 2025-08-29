<?php


namespace Bit\AppyPay\Adapters\AppyPay\Common\Mappers;


use Bit\AppyPay\Core\Application\Dto\Charge\ChargeDto;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeListOutput;
use Exception;

class ChargeMapper
{
    public static function list(array $data): ChargeListOutput
    {
        return new ChargeListOutput(
            totalCount:   (int)($data['totalCount'] ?? 0),
            hasMorePages: (bool)($data['hasMorePages'] ?? false),
            payments: array_map(/**
         * @throws Exception
         */ function ($item){
            return self::one($item);
        }, (array)($data['payments'] ?? [])),
        );
    }

    /**
     * @throws Exception
     */
    public static function one(array $d): ChargeDto
    {
        return ChargeDto::fromArray($d);
    }
}