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

        $this->kernel = new TestingKernel($_ENV['APP_ENV']);
        $this->kernel->boot();
    }
}
