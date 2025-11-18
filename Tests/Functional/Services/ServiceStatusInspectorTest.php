<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional\Services;

use PHPUnit\Framework\Attributes\DataProvider;
use SmartAssert\HealthCheckBundle\Tests\Functional\AbstractBaseFunctionalTestCase;
use SmartAssert\ServiceStatusInspector\ServiceStatusInspector;
use SmartAssert\ServiceStatusInspector\ServiceStatusInspectorInterface;

class ServiceStatusInspectorTest extends AbstractBaseFunctionalTestCase
{
    #[DataProvider('serviceIsRetrievedFromContainerDataProvider')]
    public function testServiceIsRetrievedFromContainer(string $serviceId): void
    {
        $service = $this->kernel->getContainer()->get($serviceId);

        self::assertInstanceOf(ServiceStatusInspectorInterface::class, $service);
        self::assertInstanceOf(ServiceStatusInspector::class, $service);
    }

    /**
     * @return array<string, array<string, string>>
     */
    public static function serviceIsRetrievedFromContainerDataProvider(): array
    {
        return [
            'health_check' => [
                'serviceId' => 'smartassert.health_check_bundle.service_status_inspector.health_check',
            ],
            'status' => [
                'serviceId' => 'smartassert.health_check_bundle.service_status_inspector.status',
            ],
        ];
    }
}
