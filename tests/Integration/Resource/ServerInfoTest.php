<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Test\Integration\Resource;

use Fschmtt\Keycloak\Representation\CpuInfo;
use Fschmtt\Keycloak\Representation\ServerInfo;
use Fschmtt\Keycloak\Test\Integration\IntegrationTestBehaviour;
use PHPUnit\Framework\TestCase;

class ServerInfoTest extends TestCase
{
    use IntegrationTestBehaviour;

    public function testCanGetServerInfo(): void
    {
        $serverInfo = $this->getKeycloak()->serverInfo()->get();

        static::assertInstanceOf(ServerInfo::class, $serverInfo);
    }

    public function testCanGetCpuInfo(): void
    {
        $this->skipIfKeycloakVersionIsLessThan('26.3.0');

        $serverInfo = $this->getKeycloak()->serverInfo()->get();
        $cpuInfo = $serverInfo->getCpuInfo();

        static::assertInstanceOf(CpuInfo::class, $cpuInfo);
        static::assertIsInt($cpuInfo->getProcessorCount());
        static::assertGreaterThan(0, $cpuInfo->getProcessorCount());
    }
}
