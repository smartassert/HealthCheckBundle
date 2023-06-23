<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional\Services;

use SmartAssert\DoctrineInspectors\EntityMappingInspector;
use SmartAssert\DoctrineInspectors\QueryInspector;
use SmartAssert\HealthCheckBundle\Services\DoctrineInspector;
use SmartAssert\HealthCheckBundle\Tests\Functional\AbstractBaseFunctionalTestCase;
use SmartAssert\ServiceStatusInspector\ServiceStatusInspectorInterface;
use webignition\ObjectReflector\ObjectReflector;

class HealthCheckServiceStatusInspectorTest extends AbstractBaseFunctionalTestCase
{
    private ServiceStatusInspectorInterface $serviceStatusInspector;

    protected function setUp(): void
    {
        parent::setUp();

        $serviceStatusInspector = $this->kernel->getContainer()->get(
            'smartassert.health_check_bundle.service_status_inspector.health_check'
        );
        \assert($serviceStatusInspector instanceof ServiceStatusInspectorInterface);
        $this->serviceStatusInspector = $serviceStatusInspector;
    }

    public function testDefaultConfiguration(): void
    {
        $componentInspectors = ObjectReflector::getProperty($this->serviceStatusInspector, 'componentStatusInspectors');
        self::assertIsArray($componentInspectors);
        self::assertSame(['database_connection', 'database_entities'], array_keys($componentInspectors));

        $databaseConnectionInspector = $componentInspectors['database_connection'];
        self::assertInstanceOf(DoctrineInspector::class, $databaseConnectionInspector);

        $databaseConnectionInspectorInner = $databaseConnectionInspector->getInner();
        self::assertInstanceOf(QueryInspector::class, $databaseConnectionInspectorInner);
        self::assertSame('SELECT 1', ObjectReflector::getProperty($databaseConnectionInspectorInner, 'query'));

        $databaseEntitiesInspector = $componentInspectors['database_entities'];
        self::assertInstanceOf(DoctrineInspector::class, $databaseEntitiesInspector);
        self::assertInstanceOf(EntityMappingInspector::class, $databaseEntitiesInspector->getInner());
    }

    public function testDatabaseConnectionInspector(): void
    {
        $componentInspectors = ObjectReflector::getProperty($this->serviceStatusInspector, 'componentStatusInspectors');
        self::assertIsArray($componentInspectors);
        self::assertSame(['database_connection', 'database_entities'], array_keys($componentInspectors));

        $inspector = $componentInspectors['database_connection'];
        self::assertInstanceOf(DoctrineInspector::class, $inspector);

        $inspectorInner = $inspector->getInner();
        self::assertInstanceOf(QueryInspector::class, $inspectorInner);

        $inspector->getStatus();
    }

    public function testDatabaseEntitiesInspector(): void
    {
        $componentInspectors = ObjectReflector::getProperty($this->serviceStatusInspector, 'componentStatusInspectors');
        self::assertIsArray($componentInspectors);
        self::assertSame(['database_connection', 'database_entities'], array_keys($componentInspectors));

        $inspector = $componentInspectors['database_entities'];
        self::assertInstanceOf(DoctrineInspector::class, $inspector);

        $inspectorInner = $inspector->getInner();
        self::assertInstanceOf(EntityMappingInspector::class, $inspectorInner);

        $inspector->getStatus();
    }

    public function testGet(): void
    {
        self::assertSame(
            ['database_connection' => true, 'database_entities' => true],
            $this->serviceStatusInspector->get()
        );
    }
}
