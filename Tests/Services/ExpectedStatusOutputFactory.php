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
    ) {
    }

    /**
     * @return string[]
     */
    public function getExpectedComponentNames(): array
    {
        $componentNames = array_keys($this->testComponentAvailabilities);

        if (false === $this->isDefaultTestEnvironment()) {
            $componentNames[] = 'ready';
        }

        return $componentNames;
    }

    /**
     * @return array<string, bool>
     */
    public function getExpectedComponentAvailabilities(): array
    {
        $availabilities = $this->testComponentAvailabilities;
        if (false === $this->isDefaultTestEnvironment()) {
            $availabilities['ready'] = $this->isReadyParameter;
        }

        return $availabilities;
    }

    private function isDefaultTestEnvironment(): bool
    {
        return 'test' === $this->environment;
    }
}
