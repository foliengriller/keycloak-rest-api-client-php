<?php

declare(strict_types=1);

namespace Fschmtt\Keycloak\Http;

use Fschmtt\Keycloak\Json\JsonDecoder;
use Fschmtt\Keycloak\Serializer\Serializer;
use GuzzleHttp\Promise\Utils;

/**
 * @internal
 */
class QueryExecutor
{
    public function __construct(
        private readonly Client $client,
        private readonly Serializer $serializer,
    ) {}

    public function executeQuery(Query $query): mixed
    {
        $response = $this->client->request(
            $query->getMethod()->value,
            $query->getPath(),
        );

        if ($query->getReturnType() === 'array') {
            return (new JsonDecoder())->decode($response->getBody()->getContents());
        }

        return $this->serializer->deserialize(
            $query->getReturnType(),
            $response->getBody()->getContents(),
        );
    }

    public function executeQueries(array $queries): array
    {
        if ([] === $queries) {
            return [];
        }

        $promises = [];
        foreach ($queries as $index => $query) {
            $promises[$index] = $this->client->requestAsync(
                $query->getMethod()->value,
                $query->getPath(),
            );
        }

        $responses = Utils::unwrap($promises);
        $results = [];

        foreach ($queries as $index => $query) {
            $response = $responses[$index];
            if ($query->getReturnType() === 'array') {
                $results[] = (new JsonDecoder())->decode($response->getBody()->getContents());

                continue;
            }

            $results[] = $this->serializer->deserialize(
                $query->getReturnType(),
                $response->getBody()->getContents(),
            );
        }

        return $results;
    }
}
