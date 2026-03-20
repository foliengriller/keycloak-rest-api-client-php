<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Test\Unit\Resource;

use Fschmtt\Keycloak\Collection\ClientScopeCollection;
use Fschmtt\Keycloak\Http\CommandExecutor;
use Fschmtt\Keycloak\Http\Query;
use Fschmtt\Keycloak\Http\QueryExecutor;
use Fschmtt\Keycloak\Representation\ClientScope;
use Fschmtt\Keycloak\Resource\ClientScopes;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ClientScopes::class)]
class ClientScopesTest extends TestCase
{
    public function testGetAllClientScopes(): void
    {
        $query = new Query(
            '/admin/realms/{realm}/client-scopes',
            ClientScopeCollection::class,
            [
                'realm' => 'test-realm',
            ],
        );

        $collection = new ClientScopeCollection([
            new ClientScope(name: 'scope-a'),
            new ClientScope(name: 'scope-b'),
        ]);

        $queryExecutor = $this->createMock(QueryExecutor::class);
        $queryExecutor->expects(static::once())
            ->method('executeQuery')
            ->with($query)
            ->willReturn($collection);

        $clientScopes = new ClientScopes(
            $this->createMock(CommandExecutor::class),
            $queryExecutor,
            'master',
        );

        static::assertSame($collection, $clientScopes->all('test-realm'));
    }

    public function testGetClientScopeByNameReturnsScope(): void
    {
        $query = new Query(
            '/admin/realms/{realm}/client-scopes',
            ClientScopeCollection::class,
            [
                'realm' => 'test-realm',
            ],
        );

        $scopeA = new ClientScope(name: 'scope-a');
        $scopeB = new ClientScope(name: 'scope-b');
        $collection = new ClientScopeCollection([$scopeA, $scopeB]);

        $queryExecutor = $this->createMock(QueryExecutor::class);
        $queryExecutor->expects(static::once())
            ->method('executeQuery')
            ->with($query)
            ->willReturn($collection);

        $clientScopes = new ClientScopes(
            $this->createMock(CommandExecutor::class),
            $queryExecutor,
            'master',
        );

        static::assertSame($scopeB, $clientScopes->getByName('scope-b', 'test-realm'));
    }

    public function testGetClientScopeByNameReturnsNullWhenNotFound(): void
    {
        $query = new Query(
            '/admin/realms/{realm}/client-scopes',
            ClientScopeCollection::class,
            [
                'realm' => 'test-realm',
            ],
        );

        $collection = new ClientScopeCollection([
            new ClientScope(name: 'scope-a'),
        ]);

        $queryExecutor = $this->createMock(QueryExecutor::class);
        $queryExecutor->expects(static::once())
            ->method('executeQuery')
            ->with($query)
            ->willReturn($collection);

        $clientScopes = new ClientScopes(
            $this->createMock(CommandExecutor::class),
            $queryExecutor,
            'master',
        );

        static::assertNull($clientScopes->getByName('scope-missing', 'test-realm'));
    }
}

