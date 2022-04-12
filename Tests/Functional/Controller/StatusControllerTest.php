<?php

declare(strict_types=1);

namespace SmartAssert\HealthCheckBundle\Tests\Functional\Controller;

use SmartAssert\HealthCheckBundle\Tests\Functional\AbstractBaseFunctionalTest;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Routing\RouterInterface;

class StatusControllerTest extends AbstractBaseFunctionalTest
{
    private KernelBrowser $kernelBrowser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kernelBrowser = new KernelBrowser($this->kernel);
    }

    public function testGet(): void
    {
        $router = $this->kernel->getContainer()->get('health_check_bundle.test.public_router');
        self::assertInstanceOf(RouterInterface::class, $router);

        $this->kernelBrowser->request('GET', $router->generate('status'));
        $response = $this->kernelBrowser->getResponse();

        self::assertSame(200, $response->getStatusCode());
        self::assertSame('application/json', $response->headers->get('content-type'));

        $responseData = json_decode((string) $response->getContent(), true);
        self::assertIsArray($responseData);

        var_dump($this->getExpectedResponseData());

        self::assertEquals($this->getExpectedResponseData(), $responseData);
    }

    /**
     * @return array<mixed>
     */
    private function getExpectedResponseData(): array
    {
        $expectedResponseData = ['service1' => true, 'service2' => false];

        if (($_ENV['HEALTH_CHECK_BUNDLE_ENABLE_STATUS_READINESS_INSPECTOR'] ?? false)) {
            $expectedResponseData['ready'] = false;
        }

        return $expectedResponseData;
    }
}
