<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional\Services;

use SmartAssert\HealthCheckBundle\Tests\Functional\AbstractBaseFunctionalTest;
use SmartAssert\ServiceStatusInspector\ServiceStatusInspectorInterface;
use webignition\ObjectReflector\ObjectReflector;

class StatusServiceStatusInspectorTest extends AbstractBaseFunctionalTest
{
    private ServiceStatusInspectorInterface $serviceStatusInspector;

    protected function setUp(): void
    {
        parent::setUp();

        $serviceStatusInspector = $this->kernel->getContainer()->get(
            'smartassert.health_check_bundle.service_status_inspector.status'
        );
        \assert($serviceStatusInspector instanceof ServiceStatusInspectorInterface);
        $this->serviceStatusInspector = $serviceStatusInspector;
    }

    public function testDefaultConfiguration(): void
    {
        $componentInspectors = ObjectReflector::getProperty($this->serviceStatusInspector, 'componentInspectors');
        self::assertIsArray($componentInspectors);
        self::assertSame([], array_keys($componentInspectors));
    }

    public function testGet(): void
    {
        self::assertSame(
            [],
            $this->serviceStatusInspector->get()
        );
    }
}
