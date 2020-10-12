<?php

declare(strict_types=1);

namespace EsQb\Integration;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use EsQb\Query\AbstractQuery;
use PHPUnit\Framework\TestCase;

use function json_encode;
use function sprintf;

use const JSON_THROW_ON_ERROR;

abstract class EsQbIntegrationTest extends TestCase
{
    public const TEST_INDEX = 'test_index';
    // One of https:// www.elastic.co/guide/en/elasticsearch/reference/current/analysis-analyzers.html
    public const TEST_ANALYZER = 'simple';

    public const GEO_POINT_FIELD = 'geo_point';

    private static ?Client $client = null;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        if (self::$client !== null) {
            return;
        }

        self::$client = ClientBuilder::create()->build();
        if (self::$client->indices()->exists(['index' => self::TEST_INDEX])) {
            self::$client->indices()->delete(['index' => self::TEST_INDEX]);
        }

        self::$client->indices()->create([
            'index' => self::TEST_INDEX,
            'body' => [
                'mappings' => [
                    'dynamic' => 'strict',
                    'properties' => [
                        'geo_point' => ['type' => 'geo_point'],
                    ],
                ],
            ],
        ]);
    }

    public function assertValidQuery(AbstractQuery $query): void
    {
        $validateResult = $this->doValidateBody(['query' => $query->toQuery()]);
        $this->assertTrue(
            $validateResult['valid'],
            sprintf(
                "Invalid Query : %s\nError: %s",
                json_encode($query->toQuery(), JSON_THROW_ON_ERROR),
                $validateResult['error'] ?? $validateResult['explanations'][0]['error'] ?? ''
            )
        );
    }

    /**
     * @param array<string, mixed> $query
     *
     * @return array<string, mixed>
     */
    private function doValidateBody(array $query): array
    {
        return self::$client->indices()->validateQuery([
            'index' => self::TEST_INDEX,
            'body' => $query,
            'explain' => true,
        ]);
    }
}
