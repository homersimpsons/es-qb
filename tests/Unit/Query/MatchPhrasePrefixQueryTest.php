<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Query\MatchPhrasePrefixQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MatchPhrasePrefixQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'match_phrase_prefix' => [
            'field' => [
                'query' => 'query',
                '_name' => 'queryName',
                'boost' => 2.0,
                'analyzer' => EsQbIntegrationTest::TEST_ANALYZER,
                'max_expansions' => 1,
                'slop' => 10,
                'zero_terms_query' => 'all',
            ],
        ],
    ];

    public function testBase(): void
    {
        $query = new MatchPhrasePrefixQuery('field', 'query');
        $this->assertEquals('field', $query->getField());
        $this->assertEquals('query', $query->getQuery());
        $this->assertEquals(
            ['match_phrase_prefix' => ['field' => ['query' => 'query']]],
            $query->toQuery()
        );
    }

    public function testZeroTermsQuery(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new MatchPhrasePrefixQuery('field', 'query'))->setZeroTermsQuery('NOT_none_NOR_all');
    }

    public function testWithAll(): void
    {
        $query = new MatchPhrasePrefixQuery('field', 'query');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setAnalyzer(EsQbIntegrationTest::TEST_ANALYZER);
        $query->setMaxExpansions(1);
        $query->setSlop(10);
        $query->setZeroTermsQuery('all');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
