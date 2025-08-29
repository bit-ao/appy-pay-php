<?php


namespace Bit\AppyPay\Core\Application\Dto\Charge;


class ChargeListInput
{
    public function __construct(
        public ?float $amountFrom =null,
        public ?float $amountTo = null,
        public ?string $culture = null,
        public ?string $currency=null,
        public ?string $dateFrom=null,
        public ?string $dateTo=null,
        public ?string $disputes=null,
        public ?int $limit=null,
        public ?string $merchantTransactionId=null,
        public ?int $skip = null,
        public ?string $type = null,
    ) {}
    public function toQuery():array{
        $query = [
            'amountFrom'            => $this->amountFrom,
            'amountTo'              => $this->amountTo,
            'culture'               => $this->culture,
            'currency'              => $this->currency,
            'dateFrom'              => $this->dateFrom,
            'dateTo'                => $this->dateTo,
            'disputes'              => $this->disputes,
            'limit'                 => $this->limit,
            'merchantTransactionId' => $this->merchantTransactionId,
            'skip'                  => $this->skip,
            'type'                  => $this->type,
        ];
        return array_filter($query, static fn ($v) => $v !== null && $v !== '');
    }
}