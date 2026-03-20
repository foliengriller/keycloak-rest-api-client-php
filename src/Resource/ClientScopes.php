<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Resource;

use Fschmtt\Keycloak\Collection\ClientScopeCollection;
use Fschmtt\Keycloak\Http\Query;
use Fschmtt\Keycloak\Representation\ClientScope;

class ClientScopes extends Resource
{
    public function all(?string $realm = null): ClientScopeCollection
    {
        $realm = $this->getRealm($realm);

        return $this->queryExecutor->executeQuery(
            new Query(
                '/admin/realms/{realm}/client-scopes',
                ClientScopeCollection::class,
                [
                    'realm' => $realm,
                ],
            ),
        );
    }

    public function getByName(string $name, ?string $realm = null): ?ClientScope
    {
        $realm = $this->getRealm($realm);

        foreach ($this->all($realm) as $clientScope) {
            if ($clientScope->getName() === $name) {
                return $clientScope;
            }
        }

        return null;
    }
}

