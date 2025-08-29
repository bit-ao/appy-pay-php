<?php
namespace Bit\AppyPay\Core\Application\Dto\Application;

final class ApplicationListOutput
{
    public  int $totalCount;
    public  bool $hasMorePages;
    public  array $applications;

    /**
     */
    public function __construct(
        int $totalCount,
        bool $hasMorePages,
        array $applications,
    ) {
        $this->totalCount   = $totalCount;
        $this->hasMorePages = $hasMorePages;
        $this->applications = $applications;
    }
}
