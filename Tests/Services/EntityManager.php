<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Services;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\LockMode;
use Doctrine\DBAL\Result;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Internal\Hydration\AbstractHydrator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Proxy\ProxyFactory;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query\FilterCollection;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\UnitOfWork;

class EntityManager implements EntityManagerInterface
{
    private Connection $connection;
    private ClassMetadataFactory $metadataFactory;

    public function __construct()
    {
        $statement = \Mockery::mock(Statement::class);
        $statement
            ->shouldReceive('executeQuery')
            ->andReturn(\Mockery::mock(Result::class))
        ;

        $this->connection = \Mockery::mock(Connection::class);
        $this->connection
            ->shouldReceive('prepare')
            ->with('SELECT 1')
            ->andReturn($statement)
        ;

        $this->metadataFactory = \Mockery::mock(ClassMetadataFactory::class);
        $this->metadataFactory
            ->shouldReceive('getAllMetadata')
            ->andReturn([])
        ;
    }

    public function getMetadataFactory(): ClassMetadataFactory
    {
        return $this->metadataFactory;
    }

    public function getRepository($className): EntityRepository
    {
        return \Mockery::mock(EntityRepository::class);
    }

    public function getCache(): null
    {
        return null;
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function getExpressionBuilder(): Expr
    {
        return \Mockery::mock(Expr::class);
    }

    public function beginTransaction(): void {}

    public function commit(): void {}

    public function rollback(): void {}

    public function createQuery($dql = ''): Query
    {
        return \Mockery::mock(Query::class);
    }

    public function createQueryBuilder(): QueryBuilder
    {
        return \Mockery::mock(QueryBuilder::class);
    }

    public function getReference($entityName, $id): null
    {
        return null;
    }

    public function getPartialReference($entityName, $identifier) {}

    public function close(): void {}

    public function lock($entity, $lockMode, $lockVersion = null): void {}

    public function getEventManager(): EventManager
    {
        return \Mockery::mock(EventManager::class);
    }

    public function getConfiguration(): Configuration
    {
        return \Mockery::mock(Configuration::class);
    }

    public function isOpen(): bool
    {
        return true;
    }

    public function getUnitOfWork(): UnitOfWork
    {
        return \Mockery::mock(UnitOfWork::class);
    }

    public function newHydrator($hydrationMode): AbstractHydrator
    {
        return \Mockery::mock(AbstractHydrator::class);
    }

    public function getProxyFactory(): ProxyFactory
    {
        return \Mockery::mock(ProxyFactory::class);
    }

    public function getFilters(): FilterCollection
    {
        return \Mockery::mock(FilterCollection::class);
    }

    public function isFiltersStateClean(): bool
    {
        return true;
    }

    public function hasFilters(): bool
    {
        return false;
    }

    public function getClassMetadata($className): ClassMetadata
    {
        return \Mockery::mock(ClassMetadata::class);
    }

    public function find(
        string $className,
        mixed $id,
        int|LockMode|null $lockMode = null,
        ?int $lockVersion = null
    ): null {
        return null;
    }

    public function persist($object): void {}

    public function remove($object): void {}

    public function clear($objectName = null): void {}

    public function detach($object): void {}

    public function refresh(object $object, int|LockMode|null $lockMode = null): void {}

    public function flush(): void {}

    public function initializeObject($obj): void {}

    public function contains($object): bool
    {
        return false;
    }

    public function wrapInTransaction(callable $func): mixed
    {
        return null;
    }

    public function createNativeQuery($sql, ResultSetMapping $rsm): NativeQuery
    {
        return \Mockery::mock(NativeQuery::class);
    }

    // doctrine/orm 2.* methods, not used in 3.
    public function copy($entity, $deep = false) {}

    public function createNamedNativeQuery($name) {}

    public function createNamedQuery($name) {}

    public function getHydrator($hydrationMode) {}

    public function transactional($func) {}

    public function isUninitializedObject(mixed $value): bool
    {
        return false;
    }
}
