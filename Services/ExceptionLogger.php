<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Services;

use SmartAssert\InvokableLogger\ExceptionLogger as InvokableExceptionLogger;
use SmartAssert\ServiceStatusInspector\ExceptionHandlerInterface;

class ExceptionLogger implements ExceptionHandlerInterface
{
    public function __construct(
        private readonly InvokableExceptionLogger $invokableExceptionLogger,
    ) {
    }

    public function handle(\Throwable $exception): void
    {
        ($this->invokableExceptionLogger)($exception);
    }
}
