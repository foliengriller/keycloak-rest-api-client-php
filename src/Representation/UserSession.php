<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Representation;

use Fschmtt\Keycloak\Type\Map;

/**
 * @method string|null getId()
 * @method self withId(?string $id)
 *
 * @method string|null getUsername()
 * @method self withUsername(?string $username)
 *
 * @method string|null getUserId()
 * @method self withUserId(?string $userId)
 *
 * @method string|null getIpAddress()
 * @method self withIpAddress(?string $ipAddress)
 *
 * @method int|null getStart()
 * @method self withStart(?int $start)
 *
 * @method int|null getLastAccess()
 * @method self withLastAccess(?int $lastAccess)
 *
 * @method bool|null getRememberMe()
 * @method self withRememberMe(?bool $rememberMe)
 *
 * @method Map|null getClients()
 * @method self withClients(?Map $clients)
 *
 * @method bool|null getTransientUser()
 * @method self withTransientUser(?bool $transientUser)
 *
 * @codeCoverageIgnore
 */
class UserSession extends Representation
{
    public function __construct(
        protected ?string $id = null,
        protected ?string $username = null,
        protected ?string $userId = null,
        protected ?string $ipAddress = null,
        protected ?int $start = null,
        protected ?int $lastAccess = null,
        protected ?bool $rememberMe = null,
        protected ?Map $clients = null,
        protected ?bool $transientUser = null,
    ) {}
}

