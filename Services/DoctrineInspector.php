<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Services;

use SmartAssert\DoctrineInspectors\EntityMappingInspector;
use SmartAssert\DoctrineInspectors\QueryInspector;
use SmartAssert\ServiceStatusInspector\ComponentStatusInspectorInterface;

readonly class DoctrineInspector implements ComponentStatusInspectorInterface
{
    public function __construct(
        private EntityMappingInspector|QueryInspector $inspector,
        private string $identifier,
    ) {
    }

    public function getStatus(): bool
    {
        return $this->inspector->getStatus();
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getInner(): EntityMappingInspector|QueryInspector
    {
        return $this->inspector;
    }
}
