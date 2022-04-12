<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Controller;

use SmartAssert\ServiceStatusInspector\ServiceStatusInspectorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class HealthCheckController
{
    public function __construct(
        private readonly ServiceStatusInspectorInterface $serviceStatusInspector,
    ) {
    }

    public function get(): JsonResponse
    {
        return new JsonResponse(
            $this->serviceStatusInspector->get(),
            $this->serviceStatusInspector->isAvailable() ? 200 : 503
        );
    }
}
