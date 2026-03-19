<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Representation;

use Fschmtt\Keycloak\Attribute\Since;

/**
 * @method int|null getProcessorCount()
 * @method self withProcessorCount(?int $processorCount)
 *
 * @codeCoverageIgnore
 */
#[Since('26.3.0')]
class CpuInfo extends Representation
{
    public function __construct(
        protected ?int $processorCount = null,
    ) {}
}
