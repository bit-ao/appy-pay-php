<?php


namespace Bit\AppyPay\Core\Application\Dto\Charge;


final class ChargeListOutput
{
    public  int $totalCount;
    public  bool $hasMorePages;
    /*
     * Charme[] $payments*/
    public  array $payments;
    public function __construct(
        int $totalCount,
        bool $hasMorePages,
        array $payments,
    ) {
        $this->totalCount   = $totalCount;
        $this->hasMorePages = $hasMorePages;
        $this->payments = $payments;
    }
}