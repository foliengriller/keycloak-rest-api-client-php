<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Collection;

use Fschmtt\Keycloak\Representation\UserSession;

/**
 * @extends Collection<UserSession>
 *
 * @codeCoverageIgnore
 */
class UserSessionCollection extends Collection
{
    public static function getRepresentationClass(): string
    {
        return UserSession::class;
    }
}

