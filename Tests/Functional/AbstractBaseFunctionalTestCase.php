<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractBaseFunctionalTestCase extends TestCase
{
    protected KernelInterface $kernel;

    protected function setUp(): void
    {
        parent::setUp();

        $environment = $_ENV['APP_ENV'] ?? 'test';
        $environment = is_string($environment) ? $environment : 'test';

        $this->kernel = new TestingKernel($environment);
        $this->kernel->boot();
    }

    protected function tearDown(): void
    {
        restore_exception_handler();
    }
}
