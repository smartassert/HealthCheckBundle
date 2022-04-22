<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Services;

use SmartAssert\DoctrineInspectors\EntityMappingInspector;
use SmartAssert\DoctrineInspectors\QueryInspector;
use SmartAssert\ServiceStatusInspector\ComponentStatusInspectorInterface;

class DoctrineInspector implements ComponentStatusInspectorInterface
{
    public function __construct(
        private readonly EntityMappingInspector|QueryInspector $inspector,
        private readonly string $identifier,
    ) {
    }

    public function getStatus(): bool
    {
        ($this->inspector)();

        return true;
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
