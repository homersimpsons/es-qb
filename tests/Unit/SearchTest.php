<?php

declare(strict_types=1);

namespace EsQb\Unit;

use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Query\TermQuery;
use EsQb\Search;
use PHPUnit\Framework\TestCase;

use function array_merge;

class SearchTest extends TestCase
{
    public const FULL_SEARCH_GET = [
        'index' => 'test_index',
        'allow_no_indices' => false,
        'allow_partial_search_results' => false,
        'batched_reduce_size' => 1024,
        'ccs_minimize_roundtrips' => false,
        'docvalue_fields' => 'filed',
        'expand_wildcards' => 'all',
        'explain' => true,
        'from' => 1,
        'ignore_throttled' => false,
        'ignore_unavailable' => true,
        'max_concurrent_shard_requests' => 10,
        'pre_filter_shard_size' => 1,
        'preference' => '_only_local',
        'q' => 'field:value',
        'request_cache' => true,
        'rest_total_hits_as_int' => true,
        'routing' => '',
        'scroll' => '5d',
        'search_type' => 'dfs_query_then_fetch',
        'seq_no_primary_term' => true,
        'size' => 1,
        'sort' => 'field:ASC',
        '_source' => 'field',
        'stats' => 'my_stats',
        'stored_fields' => 'field',
        'suggest_field' => 'field',
        'terminate_after' => 1,
        'timeout' => '5d',
        'track_scores' => true,
        'track_total_hits' => true,
        'typed_keys' => false,
        'version' => true,
    ];

    public const FULL_SEARCH_BODY = [
        'index' => 'test_index',
        'body' => [
            'docvalue_fields' => ['field'],
            'explain' => true,
            'from' => 1,
            'seq_no_primary_term' => true,
            'size' => 1,
            '_source' => ['field'],
            'stats' => ['my_stats'],
            'terminate_after' => 1,
            'timeout' => '5d',
            'version' => true,
            'indices_boost' => ['*' => 2.0],
            'min_score' => 2.0,
            'query' => ['term' => ['field' => ['value' => 'value']]],
        ],
    ];

    public function testCompleteGet(): void
    {
        $search = new Search(EsQbIntegrationTest::TEST_INDEX);
        $search->setAllowNoIndices(false);
        $search->setAllowPartialSearchResults(false);
        $search->setBatchedReduceSize(1024);
        $search->setCcsMinimizeRoundtrips(false);
        $search->setDocvalueFields('filed');
        $search->setExpandWildcards('all');
        $search->setExplain(true);
        $search->setFrom(1);
        $search->setIgnoreThrottled(false);
        $search->setIgnoreUnavailable(true);
        $search->setMaxConcurrentShardRequests(10);
        $search->setPreFilterShardSize(1);
        $search->setPreference('_only_local');
        $search->setQ('field:value');
        $search->setRequestCache(true);
        $search->setRestTotalHitsAsInt(true);
        $search->setRouting('');
        $search->setScroll('5d');
        $search->setSearchType('dfs_query_then_fetch');
        $search->setSeqNoPrimaryTerm(true);
        $search->setSize(1);
        $search->setSort('field:ASC');
        $search->setSource('field');
        $search->setStats('my_stats');
        $search->setStoredFields('field');
        $search->setSuggestField('field');
        $search->setTerminateAfter(1);
        $search->setTimeout('5d');
        $search->setTrackScores(true);
        $search->setTrackTotalHits(true);
        $search->setTypedKeys(false);
        $search->setVersion(true);

        $this->assertEquals(self::FULL_SEARCH_GET, $search->toSearch(true));
    }

    public function testCompleteBody(): void
    {
        $search = new Search(EsQbIntegrationTest::TEST_INDEX);
        $search->setDocvalueFields(['field']);
        $search->setExplain(true);
        $search->setFrom(1);
        $search->setIndicesBoost(['*' => 2.]);
        $search->setMinScore(2.);
        $search->setQuery(new TermQuery('field', 'value'));
        $search->setSeqNoPrimaryTerm(true);
        $search->setSize(1);
        $search->setSource(['field']);
        $search->setStats(['my_stats']);
        $search->setTerminateAfter(1);
        $search->setTimeout('5d');
        $search->setVersion(true);

        $this->assertEquals(self::FULL_SEARCH_BODY, $search->toSearch(false));
    }

    public function testPreferredGet(): void
    {
        $search = new Search('test');
        $search->setExplain(true);
        $search->setFrom(1);
        $search->setSeqNoPrimaryTerm(true);
        $search->setSize(1);
        $search->setSource(false);
        $search->setTerminateAfter(1);
        $search->setTimeout('5d');
        $search->setVersion(false);

        $params = [
            'explain' => true,
            'from' => 1,
            'seq_no_primary_term' => true,
            'size' => 1,
            '_source' => false,
            'terminate_after' => 1,
            'timeout' => '5d',
        ];
        $this->assertEquals($search->toSearch(false), $search->toSearch());
        $this->assertEquals(array_merge(['index' => 'test'], $params), $search->toSearch(true));
        $this->assertEquals(['index' => 'test', 'body' => $params], $search->toSearch(false));
    }

    public function testFallbackToBody(): void
    {
        $search = new Search('test');
        $search->setDocvalueFields('field');
        $search->setSource('field');
        $search->setStats('my_stats');
        $this->assertEquals(
            ['index' => 'test', 'docvalue_fields' => 'field', '_source' => 'field', 'stats' => 'my_stats'],
            $search->toSearch(true)
        );
        $search->setDocvalueFields(['field']);
        $search->setSource(['field']);
        $search->setStats(['my_stats']);
        $this->assertEquals(
            [
                'index' => 'test',
                'body' => [
                    'docvalue_fields' => ['field'],
                    '_source' => ['field'],
                    'stats' => ['my_stats'],
                ],
            ],
            $search->toSearch(true)
        );
    }

    public function testSource(): void
    {
        $search = new Search('test');
        // Test defaults
        $this->assertEquals(Search::DEFAULT_SOURCE, $search->getSource());
        $this->assertNull($search->getSourceExcludes());
        $this->assertNull($search->getSourceIncludes());
        // Test `setSource`
        $search->setSource('field');
        $this->assertEquals('field', $search->getSource());
        $this->assertNull($search->getSourceExcludes());
        $this->assertNull($search->getSourceIncludes());
        // Test `setSourceExcludes` resets `_source`
        $search->setSourceExcludes(['field']);
        $this->assertEquals(Search::DEFAULT_SOURCE, $search->getSource());
        $this->assertEquals(['field'], $search->getSourceExcludes());
        $this->assertNull($search->getSourceIncludes());
        // Test `setSource` resets `_source_excludes`
        $search->setSource('field');
        $this->assertEquals('field', $search->getSource());
        $this->assertNull($search->getSourceExcludes());
        $this->assertNull($search->getSourceIncludes());
        // Test `setSourceIncludes` resets `_source`
        $search->setSourceIncludes(['field']);
        $this->assertEquals(Search::DEFAULT_SOURCE, $search->getSource());
        $this->assertNull($search->getSourceExcludes());
        $this->assertEquals(['field'], $search->getSourceIncludes());
        // Test `setSource` resets `_source_includes`
        $search->setSource('field');
        $this->assertEquals('field', $search->getSource());
        $this->assertNull($search->getSourceExcludes());
        $this->assertNull($search->getSourceIncludes());
        // Test `_source_includes` and`_source_excludes`
        $search->setSourceExcludes(['exclude']);
        $search->setSourceIncludes(['include']);
        $this->assertEquals(
            ['index' => 'test', '_source_excludes' => 'exclude', '_source_includes' => 'include'],
            $search->toSearch(true)
        );
        $this->assertEquals(
            ['index' => 'test', 'body' => ['_source' => ['excludes' => ['exclude'], 'includes' => ['include']]]],
            $search->toSearch(false)
        );
    }
}
