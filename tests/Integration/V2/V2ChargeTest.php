<?php
declare(strict_types=1);

namespace Tests\Integration\V2;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeCreateInput;
use Bit\AppyPay\Core\Application\Dto\Charge\ChargeListInput;
use Bit\AppyPay\Core\Application\Dto\PaymentInfo\PaymentInfoPhoneDto;
use Tests\Integration\Support\IntegrationTestCase;

/** @group integration */
final class V2ChargeTest extends IntegrationTestCase
{
    public function test_charge_list_and_get_one(): void
    {
        $page = self::$gateway->charge()->list(new ChargeListInput());
        $this->assertGreaterThanOrEqual(1, $page->totalCount);
        $this->assertNotEmpty($page->payments);
        $this->assertNotEmpty($page->payments[0]->id);
        $this->assertNotEmpty($page->payments[0]->status);

    }

    public function test_charge_create_ref(): void
    {
        $dto = new ChargeCreateInput(
            merchantTransactionId :"sd",
            paymentMethod:"",
        paymentInfo :new PaymentInfoPhoneDto()
        currency = "AOA":
        amount = 1:
        notify = null :
        );
        $page = self::$gateway->charge()->create(new ChargeCreateInput());
        $this->assertGreaterThanOrEqual(1, $page->totalCount);
        $this->assertNotEmpty($page->payments);
        $this->assertNotEmpty($page->payments[0]->id);
        $this->assertNotEmpty($page->payments[0]->status);
    }


}
