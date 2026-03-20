<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Resource;

use Fschmtt\Keycloak\Collection\ClientScopeCollection;
use Fschmtt\Keycloak\Http\Criteria;
use Fschmtt\Keycloak\Http\Query;

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
}

