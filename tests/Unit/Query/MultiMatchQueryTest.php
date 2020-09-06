<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Query\MultiMatchQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MultiMatchQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'multi_match' => [
            'query' => 'query',
            'fields' => ['field'],
            '_name' => 'queryName',
            'boost' => 2.0,
            'type' => 'best_fields',
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
            'tie_breaker' => 0.3,
        ],
    ];

    public function testBase(): void
    {
        $query = new MultiMatchQuery('query', 'field');
        $this->assertEquals('query', $query->getQuery());
        $this->assertEquals(['field'], $query->getFields());
        $this->assertEquals(
            ['multi_match' => ['query' => 'query', 'fields' => ['field']]],
            $query->toQuery()
        );
    }

    public function testOperator(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new MultiMatchQuery('query', 'field'))->setOperator('NOT_AND_NOR_OR');
    }

    public function testWithAll(): void
    {
        $query = new MultiMatchQuery('query', 'field');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setType('best_fields');
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
        $query->setTieBreaker(0.3);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
