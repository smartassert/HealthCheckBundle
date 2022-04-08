<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional\Controller;

use SmartAssert\HealthCheckBundle\Tests\Functional\AbstractBaseFunctionalTest;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Routing\RouterInterface;

class HealthCheckControllerTest extends AbstractBaseFunctionalTest
{
    private KernelBrowser $kernelBrowser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kernelBrowser = new KernelBrowser($this->kernel);
    }

    public function testFoo(): void
    {
        $router = $this->kernel->getContainer()->get('health_check_bundle.test.public_router');
        self::assertInstanceOf(RouterInterface::class, $router);

        $this->kernelBrowser->request('GET', $router->generate('health-check'));
        $response = $this->kernelBrowser->getResponse();

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('application/json', $response->headers->get('content-type'));

        $responseData = json_decode((string) $response->getContent(), true);
        self::assertIsArray($responseData);
        self::assertSame(['database_connection' => true, 'database_entities' => true], $responseData);
    }
}
