<?php


namespace Bit\AppyPay\Core\Application\DTO\Applications;


use Bit\AppyPay\Core\Domain\Entities\Application;

final class ApplicationsOutput
{
    public readonly int $totalCount;
    public readonly bool $hasMorePages;

    /** @var list<Application> */
    public readonly array $applications;

    /**
     * @param list<Application|array|\stdClass> $applications
     */
    public function __construct(
        int $totalCount,
        bool $hasMorePages,
        array $applications,
    ) {
        $this->totalCount   = $totalCount;
        $this->hasMorePages = $hasMorePages;

        if (!array_is_list($applications)) {
            throw new \InvalidArgumentException('applications deve ser uma lista (array indexado).');
        }


        $this->applications = array_map(self::coerceApplication(...), $applications);
    }

    private static function coerceApplication(mixed $item): Application
    {
        return match (true) {
            $item instanceof Application => $item,
            is_array($item)              => Application::fromArray($item),
            $item instanceof \stdClass   => Application::fromArray((array)$item),
            default => throw new \InvalidArgumentException(
                'Cada item de applications deve ser Application|array|stdClass.'
            ),
        };
    }

    public static function fromResponse(array $payload): self
    {
        return new self(
            totalCount:   (int)($payload['totalCount'] ?? 0),
            hasMorePages: (bool)($payload['hasMorePages'] ?? false),
            applications: (array)($payload['applications'] ?? []),
        );
    }
}
