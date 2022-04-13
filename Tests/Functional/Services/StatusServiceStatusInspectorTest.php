<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional\Services;

use SmartAssert\HealthCheckBundle\Tests\Functional\AbstractBaseFunctionalTest;
use SmartAssert\HealthCheckBundle\Tests\Services\ExpectedStatusOutputFactory;
use SmartAssert\ServiceStatusInspector\ServiceStatusInspectorInterface;
use webignition\ObjectReflector\ObjectReflector;

class StatusServiceStatusInspectorTest extends AbstractBaseFunctionalTest
{
    private ServiceStatusInspectorInterface $serviceStatusInspector;
    private ExpectedStatusOutputFactory $expectedStatusOutputFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $serviceStatusInspector = $this->kernel->getContainer()->get(
            'smartassert.health_check_bundle.service_status_inspector.status'
        );
        \assert($serviceStatusInspector instanceof ServiceStatusInspectorInterface);
        $this->serviceStatusInspector = $serviceStatusInspector;

        $expectedStatusOutputFactory = $this->kernel->getContainer()->get(ExpectedStatusOutputFactory::class);
        \assert($expectedStatusOutputFactory instanceof ExpectedStatusOutputFactory);
        $this->expectedStatusOutputFactory = $expectedStatusOutputFactory;
    }

    public function testDefaultTestConfiguration(): void
    {
        $componentInspectors = ObjectReflector::getProperty($this->serviceStatusInspector, 'componentInspectors');
        self::assertIsArray($componentInspectors);

        $componentNames = array_values(array_keys($componentInspectors));
        sort($componentNames);

        $expectedComponentNames = $this->expectedStatusOutputFactory->getExpectedComponentNames();
        sort($expectedComponentNames);

        self::assertEquals($expectedComponentNames, $componentNames);
    }

    public function testGet(): void
    {
        self::assertEquals(
            $this->expectedStatusOutputFactory->getExpectedComponentAvailabilities(),
            $this->serviceStatusInspector->get()
        );
    }
}
