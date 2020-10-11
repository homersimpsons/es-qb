<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Query\SimpleQueryStringQuery;
use PHPUnit\Framework\TestCase;

class SimpleQueryStringQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'simple_query_string' => [
            'query' => 'query',
            '_name' => 'queryName',
            'boost' => 2.0,
            'fields' => ['field'],
            'default_operator' => 'AND',
            'analyze_wildcard' => true,
            'analyzer' => EsQbIntegrationTest::TEST_ANALYZER,
            'auto_generate_synonyms_phrase_query' => true,
            'flags' => 'ALL',
            'fuzzy_max_expansions' => 1,
            'fuzzy_prefix_length' => 1,
            'fuzzy_transpositions' => false,
            'lenient' => true,
            'minimum_should_match' => '75%',
            'quote_field_suffix' => 'test',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['simple_query_string' => ['query' => 'query']],
            (new SimpleQueryStringQuery('query'))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new SimpleQueryStringQuery('query');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->addFields('field');
        $query->setDefaultOperator('AND');
        $query->setAnalyzeWildcard(true);
        $query->setAnalyzer(EsQbIntegrationTest::TEST_ANALYZER);
        $query->setAutoGenerateSynonymsPhraseQuery(true);
        $query->setFlags('ALL');
        $query->setFuzzyMaxExpansions(1);
        $query->setFuzzyPrefixLength(1);
        $query->setFuzzyTranspositions(false);
        $query->setLenient(true);
        $query->setMinimumShouldMatch('75%');
        $query->setQuoteFieldSuffix('test');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
