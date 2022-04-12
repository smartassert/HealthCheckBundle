<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Controller;

use SmartAssert\ServiceStatusInspector\ServiceStatusInspectorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatusController
{
    public function get(ServiceStatusInspectorInterface $serviceStatusInspector): JsonResponse
    {
        return new JsonResponse($serviceStatusInspector->get());
    }
}
