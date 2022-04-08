<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractBaseFunctionalTest extends TestCase
{
    protected KernelInterface $kernel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kernel = new TestingKernel();
        $this->kernel->boot();
    }
}
