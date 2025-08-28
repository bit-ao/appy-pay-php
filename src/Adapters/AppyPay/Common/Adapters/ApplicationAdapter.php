<?php

namespace Bit\AppyPay\Adapters\AppyPay\Common\Adapters;
use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\ApplicationMapper;
use Bit\AppyPay\Adapters\Http\HttpClient;
use Bit\AppyPay\Core\Application\Dto\Application\ApplicationDto;
use Bit\AppyPay\Core\Application\Dto\Application\ApplicationListInput;
use Bit\AppyPay\Core\Application\Dto\Application\ApplicationPageOutput;
use Bit\AppyPay\Core\Contracts\ApplicationPortInterface;
use Exception;

class ApplicationAdapter implements ApplicationPortInterface
{

    public function __construct(
        private  HttpClient $client,
    ) {}

    /**
     * @param ApplicationListInput $input
     * @return ApplicationPageOutput
     */
    public function list(ApplicationListInput $input): ApplicationPageOutput
    {
        $query = http_build_query($input->toQuery());
        $res = $this->client->request('GET', 'applications?'.$query);
        return ApplicationMapper::list($res);
    }

    /**
     * @param string $applicationId
     * @return ApplicationDto
     * @throws Exception
     */
    public function getById(string $applicationId): ApplicationDto
    {
        $res = $this->client->request('GET', 'applications/' . rawurlencode($applicationId));
        return ApplicationMapper::one($res);
    }
}