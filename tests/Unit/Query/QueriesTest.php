<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use Error;
use EsQb\Query\BoolQuery;
use EsQb\Query\BoostingQuery;
use EsQb\Query\DisMaxQuery;
use EsQb\Query\DistanceFeatureQuery;
use EsQb\Query\FuzzyQuery;
use EsQb\Query\IdsQuery;
use EsQb\Query\MatchAllQuery;
use EsQb\Query\MatchBoolPrefixQuery;
use EsQb\Query\MatchPhrasePrefixQuery;
use EsQb\Query\MatchPhraseQuery;
use EsQb\Query\MatchQuery;
use EsQb\Query\MultiMatchQuery;
use EsQb\Query\MultiTermQuery;
use EsQb\Query\PrefixQuery;
use EsQb\Query\Queries;
use EsQb\Query\QueryStringQuery;
use EsQb\Query\RangeQuery;
use EsQb\Query\RegexpQuery;
use EsQb\Query\SimpleQueryStringQuery;
use EsQb\Query\SpanContainingQuery;
use EsQb\Query\SpanFirstQuery;
use EsQb\Query\SpanMultiTermQuery;
use EsQb\Query\SpanNearQuery;
use EsQb\Query\SpanNotQuery;
use EsQb\Query\SpanOrQuery;
use EsQb\Query\SpanQuery;
use EsQb\Query\SpanTermQuery;
use EsQb\Query\SpanWithinQuery;
use EsQb\Query\TermQuery;
use EsQb\Query\WildcardQuery;
use PHPUnit\Framework\TestCase;

class QueriesTest extends TestCase
{
    public function testCannotConstruct(): void
    {
        $this->expectException(Error::class);
        new Queries();
    }

    public function testReturnRightClass(): void
    {
        $this->assertInstanceOf(MatchAllQuery::class, Queries::matchAllQuery());
        $this->assertInstanceOf(MatchQuery::class, Queries::matchQuery('field', 'query'));
        $this->assertInstanceOf(MultiMatchQuery::class, Queries::multiMatchQuery('query', 'field'));
        $this->assertInstanceOf(MatchBoolPrefixQuery::class, Queries::matchBoolPrefixQuery('field', 'query'));
        $this->assertInstanceOf(MatchPhraseQuery::class, Queries::matchPhraseQuery('field', 'query'));
        $this->assertInstanceOf(MatchPhrasePrefixQuery::class, Queries::matchPhrasePrefixQuery('field', 'query'));
        $this->assertInstanceOf(DisMaxQuery::class, Queries::disMaxQuery());
        $this->assertInstanceOf(DistanceFeatureQuery::class, Queries::distanceFeatureQuery('date', 'now', '7d'));
        $this->assertInstanceOf(IdsQuery::class, Queries::idsQuery());
        $this->assertInstanceOf(TermQuery::class, Queries::termQuery('field', 'value'));
        $this->assertInstanceOf(FuzzyQuery::class, Queries::fuzzyQuery('field', 'value'));
        $this->assertInstanceOf(PrefixQuery::class, Queries::prefixQuery('field', 'value'));
        $this->assertInstanceOf(RangeQuery::class, Queries::rangeQuery('field'));
        $this->assertInstanceOf(WildcardQuery::class, Queries::wildcardQuery('field', 'value'));
        $this->assertInstanceOf(RegexpQuery::class, Queries::regexpQuery('field', 'value'));
        $this->assertInstanceOf(QueryStringQuery::class, Queries::queryStringQuery('value'));
        $this->assertInstanceOf(SimpleQueryStringQuery::class, Queries::simpleQueryStringQuery('value'));
        $this->assertInstanceOf(
            BoostingQuery::class,
            Queries::boostingQuery(Queries::matchAllQuery(), Queries::matchAllQuery(), 0.5)
        );
        $this->assertInstanceOf(BoolQuery::class, Queries::boolQuery());
        $spanTermQuery = Queries::spanTermQuery('field', 'value');
        $this->assertInstanceOf(SpanTermQuery::class, $spanTermQuery);
        $this->assertInstanceOf(SpanFirstQuery::class, Queries::spanFirstQuery($spanTermQuery, 3));
        $this->assertInstanceOf(SpanNearQuery::class, Queries::spanNearQuery($spanTermQuery, 12));
        $this->assertInstanceOf(SpanNotQuery::class, Queries::spanNotQuery($spanTermQuery, $spanTermQuery));
        $this->assertInstanceOf(SpanOrQuery::class, Queries::spanOrQuery($spanTermQuery));
        $this->assertInstanceOf(SpanWithinQuery::class, Queries::spanWithinQuery($spanTermQuery, $spanTermQuery));
        $this->assertInstanceOf(
            SpanContainingQuery::class,
            Queries::spanContainingQuery($spanTermQuery, $spanTermQuery)
        );
        $this->assertInstanceOf(SpanMultiTermQuery::class, Queries::spanMultiTermQuery(new RangeQuery('field')));
    }

    public function testSpanQueriesInstances(): void
    {
        $spanTermQuery = Queries::spanTermQuery('field', 'value');
        $this->assertInstanceOf(SpanQuery::class, $spanTermQuery);
        $this->assertInstanceOf(SpanQuery::class, Queries::spanFirstQuery($spanTermQuery, 3));
        $this->assertInstanceOf(SpanQuery::class, Queries::spanNearQuery($spanTermQuery, 12));
        $this->assertInstanceOf(SpanQuery::class, Queries::spanNotQuery($spanTermQuery, $spanTermQuery));
        $this->assertInstanceOf(SpanQuery::class, Queries::spanOrQuery($spanTermQuery));
        $this->assertInstanceOf(SpanQuery::class, Queries::spanWithinQuery($spanTermQuery, $spanTermQuery));
        $this->assertInstanceOf(SpanQuery::class, Queries::spanContainingQuery($spanTermQuery, $spanTermQuery));
        $this->assertInstanceOf(SpanQuery::class, Queries::spanMultiTermQuery(new RangeQuery('field')));
    }

    public function testMultiSpanQueriesInstances(): void
    {
        $this->assertInstanceOf(MultiTermQuery::class, Queries::wildcardQuery('field', 'value'));
        $this->assertInstanceOf(MultiTermQuery::class, Queries::fuzzyQuery('field', 'value'));
        $this->assertInstanceOf(MultiTermQuery::class, Queries::prefixQuery('field', 'value'));
        $this->assertInstanceOf(MultiTermQuery::class, Queries::rangeQuery('field'));
        $this->assertInstanceOf(MultiTermQuery::class, Queries::regexpQuery('field', 'value'));
    }
}
