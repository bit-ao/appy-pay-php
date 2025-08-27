<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Bit\AppyPay\Core\Contracts\PaymentGatewayPort;
use Bit\AppyPay\Core\Application\DTO\Payments\CreateChargeInput;
use Bit\AppyPay\Core\Domain\ValueObjects\{Money, PaymentMethod};
use Bit\AppyPay\Adapters\AppyPay\V1\Gateway as GatewayV1;
use Bit\AppyPay\Adapters\AppyPay\V2\Gateway as GatewayV2;
use Bit\AppyPay\Adapters\Http\HttpClient;

final class GatewayContractTest extends TestCase
{
    private function fakeHttpClient(callable $handler): HttpClient
    {
        return new class($handler) implements HttpClient {
            public function __construct(private $handler) {}
            public function request(string $method, string $url, array $headers = [], ?array $body = null, int $timeout = 30): array
            {
                return ($this->handler)($method, $url, $headers, $body, $timeout);
            }
        };
    }

    public function testV1CreateAndGet(): void
    {
        $http = $this->fakeHttpClient(function($method,$url,$headers,$body){
            if ($method==='POST' && str_contains($url, '/payments')) {
                $this->assertSame('UMM', $body['method']);
                $this->assertSame(15000, $body['amount']);
                return ['id'=>'pay_1','amount'=>15000,'currency'=>'AOA','status'=>'pending','reference'=>$body['reference'] ?? null];
            }
            if ($method==='GET' && str_contains($url, '/payments/')) {
                return ['id'=>'pay_1','amount'=>15000,'currency'=>'AOA','status'=>'paid','reference'=>'PEDIDO-12345'];
            }
            return [];
        });

        $gw = new GatewayV1($http, 'KEY');
        $input = new CreateChargeInput(Money::aoaInt(15000), 'PEDIDO-12345', PaymentMethod::UMM);
        $out = $gw->createCharge($input);
        $this->assertSame('pay_1', $out->payment->id);
        $this->assertSame(15000, $out->payment->amount->amountMinor);

        $p2 = $gw->getCharge('pay_1');
        $this->assertSame('pay_1', $p2->id);
        $this->assertSame('paid', $p2->status->value);
    }

    public function testV2CreateAndGet(): void
    {
        $http = $this->fakeHttpClient(function($method,$url,$headers,$body){
            if ($method==='POST' && str_contains($url, '/payments')) {
                $this->assertSame('REF', $body['method']);
                $this->assertSame(150.00, $body['amount']['value']);
                $this->assertArrayHasKey('expiresAt', $body); // default 72h aplicado
                return ['id'=>'pay_2','amount'=>['value'=>'150.00','currency'=>'AOA'],'status'=>'pending','reference'=>'R2'];
            }
            if ($method==='GET' && str_contains($url, '/payments/')) {
                return ['id'=>'pay_2','amount'=>['value'=>'150.00','currency'=>'AOA'],'status'=>'paid','reference'=>'R2'];
            }
            return [];
        });

        $gw = new GatewayV2($http, 'KEY');
        $input = new CreateChargeInput(Money::aoaInt(15000), 'R2', PaymentMethod::REF);
        $out = $gw->createCharge($input);
        $this->assertSame('pay_2', $out->payment->id);
        $this->assertSame(15000, $out->payment->amount->amountMinor);

        $p2 = $gw->getCharge('pay_2');
        $this->assertSame('pay_2', $p2->id);
        $this->assertSame('paid', $p2->status->value);
    }
}
