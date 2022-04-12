<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Tags the 'smartassert.health_check_bundle.component_inspectors.readiness' service
 * with tag 'health_check_bundle.component_inspector.status'
 * if parameter 'health_check_bundle.enable_status_readiness_inspector'
 * resolves to boolean true
 */
class TagStatusReadinessInspectorCompilerPass implements CompilerPassInterface
{
    private const PARAMETER_NAME = 'health_check_bundle.enable_status_readiness_inspector';
    private const SERVICE_ID = 'smartassert.health_check_bundle.component_inspectors.readiness';
    private const TAG = 'health_check_bundle.component_inspector.status';

    public function process(ContainerBuilder $container): void
    {
        if (false === $container->hasParameter(self::PARAMETER_NAME)) {
            return;
        }

        $flag = $container->resolveEnvPlaceholders($container->getParameter(self::PARAMETER_NAME), true);
        $flag = is_bool($flag) ? $flag : false;

        if (false === $flag) {
            return;
        }

        if (false === $container->hasDefinition(self::SERVICE_ID)) {
            return;
        }

        $definition = $container->getDefinition(self::SERVICE_ID);
        $definition->addTag(self::TAG);
    }
}
