<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional\Services;

use SmartAssert\ServiceStatusInspector\ServiceStatusInspectorInterface;

class ServiceStatusInspectorTest extends AbstractBaseFunctionalTest
{
    public function testServiceExistsInContainer(): void
    {
        $this->assertServiceExistsInContainer(ServiceStatusInspectorInterface::class);
    }
}
