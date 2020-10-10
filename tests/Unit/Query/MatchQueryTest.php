<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Query\MatchQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MatchQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'match' => [
            'field' => [
                'query' => 'query',
                '_name' => 'queryName',
                'boost' => 2.0,
                'analyzer' => EsQbIntegrationTest::TEST_ANALYZER,
                'auto_generate_synonyms_phrase_query' => true,
                'fuzziness' => '0',
                'max_expansions' => 1,
                'prefix_length' => 1,
                'fuzzy_transpositions' => true,
                'fuzzy_rewrite' => 'constant_score_boolean',
                'lenient' => true,
                'operator' => 'AND',
                'minimum_should_match' => '75%',
                'zero_terms_query' => 'all',
            ],
        ],
    ];

    public function testBase(): void
    {
        $query = new MatchQuery('field', 'query');
        $this->assertEquals('field', $query->getField());
        $this->assertEquals('query', $query->getQuery());
        $this->assertEquals(
            ['match' => ['field' => ['query' => 'query']]],
            $query->toQuery()
        );
    }

    public function testOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new MatchQuery('field', 'query'))->setOperator('NOT_AND_NOR_OR');
    }

    public function testWithAll(): void
    {
        $query = new MatchQuery('field', 'query');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setAnalyzer(EsQbIntegrationTest::TEST_ANALYZER);
        $query->setAutoGenerateSynonymsPhraseQuery(true);
        $query->setFuzziness('0');
        $query->setMaxExpansions(1);
        $query->setPrefixLength(1);
        $query->setFuzzyTranspositions(true);
        $query->setFuzzyRewrite('constant_score_boolean');
        $query->setLenient(true);
        $query->setOperator('AND');
        $query->setMinimumShouldMatch('75%');
        $query->setZeroTermsQuery('all');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
