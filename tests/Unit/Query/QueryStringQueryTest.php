<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Query\QueryStringQuery;
use PHPUnit\Framework\TestCase;

class QueryStringQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'query_string' => [
            'query' => 'query',
            '_name' => 'queryName',
            'boost' => 2.0,
            'analyzer' => EsQbIntegrationTest::TEST_ANALYZER,
            'auto_generate_synonyms_phrase_query' => true,
            'fuzziness' => '0',
            'fuzzy_max_expansions' => 1,
            'fuzzy_prefix_length' => 1,
            'fuzzy_transpositions' => false,
            'lenient' => true,
            'minimum_should_match' => '75%',
            'default_field' => 'field',
            'allow_leading_wildcard' => false,
            'analyze_wildcard' => true,
            'default_operator' => 'AND',
            'enable_position_increments' => false,
            'fields' => ['field'],
            'rewrite' => 'constant_score_boolean',
            'max_determinized_states' => 1000,
            'quote_analyzer' => 'simple',
            'phrase_slop' => 2,
            'quote_field_suffix' => 'test',
            'time_zone' => '+01:00',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['query_string' => ['query' => 'query']],
            (new QueryStringQuery('query'))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new QueryStringQuery('query');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setDefaultField('field');
        $query->setAllowLeadingWildcard(false);
        $query->setAnalyzeWildcard(true);
        $query->setAnalyzer(EsQbIntegrationTest::TEST_ANALYZER);
        $query->setAutoGenerateSynonymsPhraseQuery(true);
        $query->setDefaultOperator('AND');
        $query->setEnablePositionIncrements(false);
        $query->addFields('field');
        $query->setFuzziness('0');
        $query->setFuzzyMaxExpansions(1);
        $query->setFuzzyPrefixLength(1);
        $query->setFuzzyTranspositions(false);
        $query->setLenient(true);
        $query->setMaxDeterminizedStates(1000);
        $query->setMinimumShouldMatch('75%');
        $query->setQuoteAnalyzer(EsQbIntegrationTest::TEST_ANALYZER);
        $query->setPhraseSlop(2);
        $query->setQuoteFieldSuffix('test');
        $query->setRewrite('constant_score_boolean');
        $query->setTimeZone('+01:00');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
