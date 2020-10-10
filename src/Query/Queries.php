<?php

declare(strict_types=1);

namespace EsQb\Query;

/**
 * @TODO https://github.com/elastic/elasticsearch/blob/237650e9c054149fd08213b38a81a3666c1868e5/server/src/main/java/org/elasticsearch/index/query/QueryBuilders.java
 *
 * Utility class to create search queries.
 */
class Queries
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
    public static function termQuery(string $fieldName, $value): TermQuery
    {
        return new TermQuery($fieldName, $value);
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
}
