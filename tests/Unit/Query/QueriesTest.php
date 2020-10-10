<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use Error;
use EsQb\Query\DisMaxQuery;
use EsQb\Query\MatchAllQuery;
use EsQb\Query\MatchBoolPrefixQuery;
use EsQb\Query\MatchPhrasePrefixQuery;
use EsQb\Query\MatchPhraseQuery;
use EsQb\Query\MatchQuery;
use EsQb\Query\MultiMatchQuery;
use EsQb\Query\Queries;
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
    }
}
