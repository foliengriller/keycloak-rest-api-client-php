<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Resource;

use Fschmtt\Keycloak\Collection\IdentityProviderCollection;
use Fschmtt\Keycloak\Collection\IdentityProviderMapperCollection;
use Fschmtt\Keycloak\Http\Command;
use Fschmtt\Keycloak\Http\Criteria;
use Fschmtt\Keycloak\Http\Method;
use Fschmtt\Keycloak\Http\Query;
use Fschmtt\Keycloak\Json\JsonDecoder;
use Fschmtt\Keycloak\Representation\IdentityProvider;
use Fschmtt\Keycloak\Representation\IdentityProviderMapper;
use Psr\Http\Message\ResponseInterface;

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
                '/admin/realms/{realm}/identity-provider/instances/{alias}',
                IdentityProvider::class,
                [
                    'realm' => $realm,
                    'alias' => $alias,
                ],
            ),
        );
    }

    public function create(IdentityProvider $identityProvider, ?string $realm = null): ResponseInterface
    {
        $realm = $this->getRealm($realm);
        return $this->commandExecutor->executeCommand(
            new Command(
                '/admin/realms/{realm}/identity-provider/instances',
                Method::POST,
                [
                    'realm' => $realm,
                ],
                $identityProvider,
            ),
        );
    }

    /**
     * @return array<mixed>
     */
    public function importConfig(string $providerId, string $fromUrl, ?string $realm = null): array
    {
        $realm = $this->getRealm($realm);
        $response = $this->commandExecutor->executeCommand(
            new Command(
                '/admin/realms/{realm}/identity-provider/import-config',
                Method::POST,
                [
                    'realm' => $realm,
                ],
                [
                    'providerId' => $providerId,
                    'fromUrl' => $fromUrl,
                ],
            ),
        );

        return (new JsonDecoder())->decode($response->getBody()->getContents());
    }

    public function getMappers(string $alias, ?string $realm = null): IdentityProviderMapperCollection
    {
        $realm = $this->getRealm($realm);
        return $this->queryExecutor->executeQuery(
            new Query(
                '/admin/realms/{realm}/identity-provider/instances/{alias}/mappers',
                IdentityProviderMapperCollection::class,
                [
                    'realm' => $realm,
                    'alias' => $alias,
                ],
            ),
        );
    }

    public function addMapper(IdentityProviderMapper $identityProviderMapper, string $alias, ?string $realm = null): ResponseInterface
    {
        $realm = $this->getRealm($realm);
        return $this->commandExecutor->executeCommand(
            new Command(
                '/admin/realms/{realm}/identity-provider/instances/{alias}/mappers',
                Method::POST,
                [
                    'realm' => $realm,
                    'alias' => $alias,
                ],
                $identityProviderMapper,
            ),
        );
    }

    public function update(string $alias, IdentityProvider $identityProvider, ?string $realm = null): ResponseInterface
    {
        $realm = $this->getRealm($realm);
        return $this->commandExecutor->executeCommand(
            new Command(
                '/admin/realms/{realm}/identity-provider/instances/{alias}',
                Method::PUT,
                [
                    'realm' => $realm,
                    'alias' => $alias,
                ],
                $identityProvider,
            ),
        );
    }

    public function updateMapper(IdentityProviderMapper $mapper, string $alias, ?string $realm = null): ResponseInterface
    {
        $realm = $this->getRealm($realm);
        return $this->commandExecutor->executeCommand(
            new Command(
                '/admin/realms/{realm}/identity-provider/instances/{alias}/mappers/{id}',
                Method::PUT,
                [
                    'realm' => $realm,
                    'alias' => $alias,
                    'id' => $mapper->getId(),
                ],
                $mapper,
            ),
        );
    }

    public function deleteMapper(string $mapperId, string $alias, ?string $realm = null): ResponseInterface
    {
        $realm = $this->getRealm($realm);
        return $this->commandExecutor->executeCommand(
            new Command(
                '/admin/realms/{realm}/identity-provider/instances/{alias}/mappers/{id}',
                Method::DELETE,
                [
                    'realm' => $realm,
                    'alias' => $alias,
                    'id' => $mapperId,
                ],
            ),
        );
    }
}
