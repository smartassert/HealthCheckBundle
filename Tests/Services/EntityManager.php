<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Services;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Result;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\Mapping\ClassMetadataFactory;

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

    public function __call(string $name, array $arguments)
    {
    }

    public function getMetadataFactory(): ClassMetadataFactory
    {
        return $this->metadataFactory;
    }

    public function getRepository($className)
    {
    }

    public function getCache()
    {
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function getExpressionBuilder()
    {
    }

    public function beginTransaction()
    {
    }

    public function transactional($func)
    {
    }

    public function commit()
    {
    }

    public function rollback()
    {
    }

    public function createQuery($dql = '')
    {
    }

    public function createNamedQuery($name)
    {
    }

    public function createNativeQuery($sql, ResultSetMapping $rsm)
    {
    }

    public function createNamedNativeQuery($name)
    {
    }

    public function createQueryBuilder()
    {
    }

    public function getReference($entityName, $id)
    {
    }

    public function getPartialReference($entityName, $identifier)
    {
    }

    public function close()
    {
    }

    public function copy($entity, $deep = false)
    {
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
    }

    public function getEventManager()
    {
    }

    public function getConfiguration()
    {
    }

    public function isOpen()
    {
    }

    public function getUnitOfWork()
    {
    }

    public function getHydrator($hydrationMode)
    {
    }

    public function newHydrator($hydrationMode)
    {
    }

    public function getProxyFactory()
    {
    }

    public function getFilters()
    {
    }

    public function isFiltersStateClean()
    {
    }

    public function hasFilters()
    {
    }

    public function getClassMetadata($className)
    {
    }

    public function find($className, $id)
    {
    }

    public function persist($object)
    {
    }

    public function remove($object)
    {
    }

    public function merge($object)
    {
    }

    public function clear($objectName = null)
    {
    }

    public function detach($object)
    {
    }

    public function refresh($object)
    {
    }

    public function flush()
    {
    }

    public function initializeObject($obj)
    {
    }

    public function contains($object)
    {
    }
}
