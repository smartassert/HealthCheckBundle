<?php

namespace SmartAssert\HealthCheckBundle;

use SmartAssert\HealthCheckBundle\DependencyInjection\TagStatusReadinessInspectorCompilerPass;
use SmartAssert\HealthCheckBundle\DependencyInjection\TagStatusVersionInspectorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HealthCheckBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new TagStatusReadinessInspectorCompilerPass());
        $container->addCompilerPass(new TagStatusVersionInspectorCompilerPass());
    }
}
