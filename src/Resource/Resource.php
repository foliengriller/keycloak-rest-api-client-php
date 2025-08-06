<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Resource;

use Fschmtt\Keycloak\Http\CommandExecutor;
use Fschmtt\Keycloak\Http\QueryExecutor;
use Fschmtt\Keycloak\Representation\Organization;

/**
 * @codeCoverageIgnore
 */
abstract class Resource
{
    public function __construct(
        protected readonly CommandExecutor $commandExecutor,
        protected readonly QueryExecutor $queryExecutor,
        protected readonly String $realm,
    ) {}
}
