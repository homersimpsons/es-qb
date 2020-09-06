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
}
