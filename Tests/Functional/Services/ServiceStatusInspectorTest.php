<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional\Services;

use SmartAssert\DoctrineInspectors\EntityMappingInspector;
use SmartAssert\DoctrineInspectors\QueryInspector;
use SmartAssert\ServiceStatusInspector\ServiceStatusInspector;
use SmartAssert\ServiceStatusInspector\ServiceStatusInspectorInterface;
use webignition\ObjectReflector\ObjectReflector;

class ServiceStatusInspectorTest extends AbstractBaseFunctionalTest
{
    private ServiceStatusInspectorInterface $serviceStatusInspector;

    protected function setUp(): void
    {
        parent::setUp();

        $serviceStatusInspector = $this->container->get(ServiceStatusInspectorInterface::class);
        \assert($serviceStatusInspector instanceof ServiceStatusInspectorInterface);
        $this->serviceStatusInspector = $serviceStatusInspector;
    }

    public function testServiceIsRetrievedFromContainer(): void
    {
        $service = $this->container->get(ServiceStatusInspectorInterface::class);

        self::assertInstanceOf(ServiceStatusInspectorInterface::class, $service);
        self::assertInstanceOf(ServiceStatusInspector::class, $service);
    }

    public function testDefaultConfiguration(): void
    {
        $componentInspectors = ObjectReflector::getProperty($this->serviceStatusInspector, 'componentInspectors');
        self::assertIsArray($componentInspectors);
        self::assertSame(['database_connection', 'database_entities'], array_keys($componentInspectors));

        $databaseConnectionInspector = $componentInspectors['database_connection'];
        self::assertInstanceOf(QueryInspector::class, $databaseConnectionInspector);
        self::assertSame('SELECT 1', ObjectReflector::getProperty($databaseConnectionInspector, 'query'));

        $databaseEntitiesInspector = $componentInspectors['database_entities'];
        self::assertInstanceOf(EntityMappingInspector::class, $databaseEntitiesInspector);
    }

    public function testInvokeDatabaseConnectionInspector(): void
    {
        $componentInspectors = ObjectReflector::getProperty($this->serviceStatusInspector, 'componentInspectors');
        self::assertIsArray($componentInspectors);
        self::assertSame(['database_connection', 'database_entities'], array_keys($componentInspectors));

        $inspector = $componentInspectors['database_connection'];
        self::assertInstanceOf(QueryInspector::class, $inspector);
        ($inspector)();
    }

    public function testInvokeDatabaseEntitiesInspector(): void
    {
        $componentInspectors = ObjectReflector::getProperty($this->serviceStatusInspector, 'componentInspectors');
        self::assertIsArray($componentInspectors);
        self::assertSame(['database_connection', 'database_entities'], array_keys($componentInspectors));

        $inspector = $componentInspectors['database_entities'];
        self::assertInstanceOf(EntityMappingInspector::class, $inspector);
        ($inspector)();
    }

    public function testInvokeServiceStatusInspector(): void
    {
        self::assertSame(
            ['database_connection' => true, 'database_entities' => true],
            $this->serviceStatusInspector->get()
        );
    }
}
