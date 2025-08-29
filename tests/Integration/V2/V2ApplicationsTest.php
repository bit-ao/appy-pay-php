<?php
declare(strict_types=1);

namespace Tests\Integration\V2;

use Tests\Integration\Support\IntegrationTestCase;
use Bit\AppyPay\Core\Application\Dto\Application\ApplicationListInput;

/** @group integration */
final class V2ApplicationsTest extends IntegrationTestCase
{
    public function test_application_list(): void
    {
        $page = self::$gateway->application()->list(new ApplicationListInput());
        $this->assertGreaterThanOrEqual(1, $page->totalCount);
        $this->assertNotEmpty($page->applications);
        $this->assertNotEmpty($page->applications[0]->id);
        $this->assertNotEmpty($page->applications[0]->name);
    }
}
