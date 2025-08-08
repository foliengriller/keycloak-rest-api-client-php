<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Resource;

use Fschmtt\Keycloak\Collection\IdentityProviderCollection;
use Fschmtt\Keycloak\Http\Criteria;
use Fschmtt\Keycloak\Http\Query;
use Fschmtt\Keycloak\Representation\IdentityProvider;

class IdentityProviders extends Resource
{
    public function all(?Criteria $criteria = null, ?string $realm = null): IdentityProviderCollection
    {
        $realm = $this->getRealm($realm);
        return $this->queryExecutor->executeQuery(
            new Query(
                '/admin/realms/{realm}/identity-provider/instances',
                IdentityProviderCollection::class,
                [
                    'realm' => $realm,
                ],
                $criteria,
            ),
        );
    }

    public function get(string $alias, ?string $realm = null): IdentityProvider
    {
        $realm = $this->getRealm($realm);
        return $this->queryExecutor->executeQuery(
            new Query(
                '/admin/realms/{realm}identity-provider/instances/{alias}',
                IdentityProviderCollection::class,
                [
                    'realm' => $realm,
                    'alias' => $alias,
                ],
            ),
        );
    }
}
