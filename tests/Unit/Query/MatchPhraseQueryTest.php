<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Query\MatchPhraseQuery;
use PHPUnit\Framework\TestCase;

class MatchPhraseQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'match_phrase' => [
            'field' => [
                'query' => 'query',
                'analyzer' => EsQbIntegrationTest::TEST_ANALYZER,
                'boost' => 2.0,
                '_name' => 'test',
            ],
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['match_phrase' => ['field' => ['query' => 'query']]],
            (new MatchPhraseQuery('field', 'query'))->toQuery()
        );
    }

    public function testFullQuery(): void
    {
        $query = new MatchPhraseQuery('field', 'query');
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $query->setAnalyzer(EsQbIntegrationTest::TEST_ANALYZER);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
