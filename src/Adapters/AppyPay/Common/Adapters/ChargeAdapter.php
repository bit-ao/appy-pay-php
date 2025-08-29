<?php


namespace Bit\AppyPay\Adapters\AppyPay\Common\Adapters;


use Bit\AppyPay\Adapters\AppyPay\Common\Mappers\ChargeMapper;
use Bit\AppyPay\Adapters\Http\HttpClient;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeCreateInput;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeDto;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeListInput;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeListOutput;
use Bit\AppyPay\Core\Contracts\ChargePortInterface;
use Exception;

class ChargeAdapter implements ChargePortInterface
{
    public function __construct(
        private  HttpClient $client,
    ) {}
    /**
     * @param ChargeListInput $input
     * @return ChargeListOutput
     */
    public function list(ChargeListInput $input): ChargeListOutput
    {
        $query = http_build_query($input->toQuery());
        $res = $this->client->request('GET', 'charges?'.$query);
        return ChargeMapper::list($res);
    }

    /**
     * @param string $chargeId
     * @return ChargeDto
     */
    public function get(string $chargeId): ChargeDto
    {
        // TODO: Implement get() method.
    }


    /**
     * @throws Exception
     */
    public function create(ChargeCreateInput $input): ChargeDto
    {
        $res = $this->client->request('POST', 'charges',[],$input->toArray());
        return ChargeMapper::one($res);
    }
}