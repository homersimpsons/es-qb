<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use Error;
use EsQb\Query\MatchAllQuery;
use EsQb\Query\MatchBoolPrefixQuery;
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
    }
}
