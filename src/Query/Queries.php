<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\GeoPoint;
use EsQb\Query\FunctionScore\AbstractScoreFunction;
use EsQb\Script;

/**
 * @TODO https://github.com/elastic/elasticsearch/blob/237650e9c054149fd08213b38a81a3666c1868e5/server/src/main/java/org/elasticsearch/index/query/QueryBuilders.java
 *
 * Utility class to create search queries.
 */
final class Queries
{
    private function __construct()
    {
    }

    /**
     * A query that matches on all documents.
     */
    public static function matchAllQuery(): MatchAllQuery
    {
        return new MatchAllQuery();
    }

    /**
     * Creates a match query for the provided field name and text.
     */
    public static function matchQuery(string $field, string $query): MatchQuery
    {
        return new MatchQuery($field, $query);
    }

    /**
     * Creates a match query for the provided field names and text.
     */
    public static function multiMatchQuery(string $query, string ...$fields): MultiMatchQuery
    {
        return new MultiMatchQuery($query, ...$fields);
    }

    /**
     * Creates a match boolean prefix query for the provided field name and text.
     */
    public static function matchBoolPrefixQuery(string $field, string $query): MatchBoolPrefixQuery
    {
        return new MatchBoolPrefixQuery($field, $query);
    }

    /**
     * Creates a match phrase prefix query for the provided field name and text.
     */
    public static function matchPhraseQuery(string $field, string $query): MatchPhraseQuery
    {
        return new MatchPhraseQuery($field, $query);
    }

    /**
     * Creates a match phrase prefix query for the provided field name and text.
     */
    public static function matchPhrasePrefixQuery(string $field, string $query): MatchPhrasePrefixQuery
    {
        return new MatchPhrasePrefixQuery($field, $query);
    }

    /**
     * Creates a disjunction max query.
     */
    public static function disMaxQuery(): DisMaxQuery
    {
        return new DisMaxQuery();
    }

    /**
     * Creates a distance feature query.
     */
    public static function distanceFeatureQuery(string $field, string $origin, string $pivot): DistanceFeatureQuery
    {
        return new DistanceFeatureQuery($field, $origin, $pivot);
    }

    /**
     * Creates a IDs query.
     */
    public static function idsQuery(): IdsQuery
    {
        return new IdsQuery();
    }

    /**
     * Creates a term query.
     *
     * @param string|int|float|bool $value
     */
    public static function termQuery(string $field, $value): TermQuery
    {
        return new TermQuery($field, $value);
    }

    /**
     * Creates a fuzzy query.
     */
    public static function fuzzyQuery(string $field, string $query): FuzzyQuery
    {
        return new FuzzyQuery($field, $query);
    }

    /**
     * Creates a prefix query.
     */
    public static function prefixQuery(string $field, string $query): PrefixQuery
    {
        return new PrefixQuery($field, $query);
    }

    /**
     * Creates a range query.
     */
    public static function rangeQuery(string $field): RangeQuery
    {
        return new RangeQuery($field);
    }

    /**
     * Creates a wildcard query.
     */
    public static function wildcardQuery(string $field, string $query): WildcardQuery
    {
        return new WildcardQuery($field, $query);
    }

    /**
     * Creates a regexp query.
     */
    public static function regexpQuery(string $field, string $regexp): RegexpQuery
    {
        return new RegexpQuery($field, $regexp);
    }

    /**
     * Creates a query string query.
     */
    public static function queryStringQuery(string $query): QueryStringQuery
    {
        return new QueryStringQuery($query);
    }

    /**
     * Creates a simple query string query.
     */
    public static function simpleQueryStringQuery(string $query): SimpleQueryStringQuery
    {
        return new SimpleQueryStringQuery($query);
    }

    /**
     * Creates a boosting query.
     */
    public static function boostingQuery(
        AbstractQuery $positive,
        AbstractQuery $negative,
        float $negativeBoost
    ): BoostingQuery {
        return new BoostingQuery($positive, $negative, $negativeBoost);
    }

    /**
     * Creates a bool query.
     */
    public static function boolQuery(): BoolQuery
    {
        return new BoolQuery();
    }

    /**
     * Creates a span term query.
     *
     * @param string|int|float|bool $value
     */
    public static function spanTermQuery(string $field, $value): SpanTermQuery
    {
        return new SpanTermQuery($field, $value);
    }

    /**
     * Creates a span first query.
     */
    public static function spanFirstQuery(SpanQuery $match, int $end): SpanFirstQuery
    {
        return new SpanFirstQuery($match, $end);
    }

    /**
     * Creates a span near query.
     */
    public static function spanNearQuery(SpanQuery $initialClause, int $slop): SpanNearQuery
    {
        return new SpanNearQuery($initialClause, $slop);
    }

    /**
     * Creates a span not query.
     */
    public static function spanNotQuery(SpanQuery $include, SpanQuery $exclude): SpanNotQuery
    {
        return new SpanNotQuery($include, $exclude);
    }

    /**
     * Creates a span or query.
     */
    public static function spanOrQuery(SpanQuery $initialClause): SpanOrQuery
    {
        return new SpanOrQuery($initialClause);
    }

    /**
     * Creates a span not query.
     */
    public static function spanWithinQuery(SpanQuery $big, SpanQuery $little): SpanWithinQuery
    {
        return new SpanWithinQuery($big, $little);
    }

    /**
     * Creates a span containing query.
     */
    public static function spanContainingQuery(SpanQuery $big, SpanQuery $little): SpanContainingQuery
    {
        return new SpanContainingQuery($big, $little);
    }

    /**
     * Creates a span multi query.
     */
    public static function spanMultiTermQuery(MultiTermQuery $multiTermQuery): SpanMultiTermQuery
    {
        return new SpanMultiTermQuery($multiTermQuery);
    }

    /**
     * Creates a span field masking query.
     */
    public static function spanFieldMaskingQuery(SpanQuery $query, string $field): SpanFieldMaskingQuery
    {
        return new SpanFieldMaskingQuery($query, $field);
    }

    /**
     * Creates a constant score query.
     */
    public static function constantScoreQuery(AbstractQuery $query): ConstantScoreQuery
    {
        return new ConstantScoreQuery($query);
    }

    /**
     * Creates a function score query.
     */
    public static function functionScoreQuery(
        AbstractQuery $query,
        AbstractScoreFunction $function,
        float $functionWeight = FunctionScoreQuery::DEFAULT_WEIGHT,
        ?AbstractQuery $functionFilter = null
    ): FunctionScoreQuery {
        return new FunctionScoreQuery($query, $function, $functionWeight, $functionFilter);
    }

    /**
     * Creates a script score query.
     */
    public static function scriptScoreQuery(AbstractQuery $query, Script $script): ScriptScoreQuery
    {
        return new ScriptScoreQuery($query, $script);
    }

    /**
     * Creates a nested query.
     */
    public static function nestedQuery(
        string $path,
        AbstractQuery $query,
        string $scoreMode = NestedQuery::DEFAULT_SCORE_MODE
    ): NestedQuery {
        return new NestedQuery($path, $query, $scoreMode);
    }

    /**
     * Creates a terms query.
     *
     * @param array<string|int|float|bool> $value
     */
    public static function termsQuery(string $field, array $value): TermsQuery
    {
        return new TermsQuery($field, $value);
    }

    /**
     * Creates a script query.
     */
    public static function scriptQuery(Script $script): ScriptQuery
    {
        return new ScriptQuery($script);
    }

    /**
     * Creates a geo distance query.
     */
    public static function geoDistanceQuery(string $field, GeoPoint $origin, string $distance): GeoDistanceQuery
    {
        return new GeoDistanceQuery($field, $origin, $distance);
    }

    /**
     * Creates a geo bounding box query.
     */
    public static function geoBoundingBoxQuery(
        string $field,
        GeoPoint $topLeft,
        GeoPoint $bottomRight
    ): GeoBoundingBoxQuery {
        return new GeoBoundingBoxQuery($field, $topLeft, $bottomRight);
    }

    /**
     * Creates a geo polygon query.
     *
     * @param GeoPoint[] $points
     */
    public static function geoPolygonQuery(string $field, array $points): GeoPolygonQuery
    {
        return new GeoPolygonQuery($field, $points);
    }

    /**
     * Creates a exists query.
     */
    public static function existsQuery(string $field): ExistsQuery
    {
        return new ExistsQuery($field);
    }
}
