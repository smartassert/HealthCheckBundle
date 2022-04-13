<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\DependencyInjection;

use SmartAssert\HealthCheckBundle\HealthCheckBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HealthCheckExtension extends Extension
{
    /**
     * @param array<mixed> $configs
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $serviceConfigurationPaths = [
            'services.yaml',
        ];

        $configurationPath = $this->getConfigurationPath($container) . '/Resources/config';

        $loader = new YamlFileLoader($container, new FileLocator($configurationPath));
        foreach ($serviceConfigurationPaths as $serviceConfigurationPath) {
            $path = $configurationPath . '/' . $serviceConfigurationPath;

            if (file_exists($path)) {
                $loader->load($serviceConfigurationPath);
            }
        }
    }

    private function getConfigurationPath(ContainerBuilder $container): string
    {
        $metadataCollection = $container->getParameter('kernel.bundles_metadata');
        $metadataCollection = is_array($metadataCollection) ? $metadataCollection : [];

        $metadata = $metadataCollection[(new HealthCheckBundle())->getName()] ?? [];
        $metadata = is_array($metadata) ? $metadata : [];

        return $metadata['path'] ?? '';
    }
}
