<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Services;

class ExpectedStatusOutputFactory
{
    /**
     * @var array<string, bool>
     */
    private array $testComponentAvailabilities = [
        'service1' => true,
        'service2' => false,
    ];

    public function __construct(
        private readonly string $environment,
        private readonly bool $isReadyParameter,
        private readonly string $versionParameter,
    ) {}

    /**
     * @return string[]
     */
    public function getExpectedComponentNames(): array
    {
        $componentNames = array_keys($this->testComponentAvailabilities);

        if ($this->isReadinessInspectorTestEnvironment()) {
            $componentNames[] = 'ready';
        }

        if ($this->isVersionInspectorTestEnvironment()) {
            $componentNames[] = 'version';
        }

        return $componentNames;
    }

    /**
     * @return array<string, bool|string>
     */
    public function getExpectedComponentAvailabilities(): array
    {
        $availabilities = $this->testComponentAvailabilities;

        if ($this->isReadinessInspectorTestEnvironment()) {
            $availabilities['ready'] = $this->isReadyParameter;
        }

        if ($this->isVersionInspectorTestEnvironment()) {
            $availabilities['version'] = $this->versionParameter;
        }

        return $availabilities;
    }

    private function isReadinessInspectorTestEnvironment(): bool
    {
        return str_starts_with($this->environment, 'test_readiness_inspector');
    }

    private function isVersionInspectorTestEnvironment(): bool
    {
        return 'test_version_inspector_enabled' === $this->environment;
    }
}
