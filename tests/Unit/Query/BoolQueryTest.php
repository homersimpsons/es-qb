<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\BoolQuery;
use EsQb\Query\TermQuery;
use PHPUnit\Framework\TestCase;

class BoolQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'bool' => [
            'must' => [['term' => ['field' => ['value' => 'must']]]],
            'filter' => [['term' => ['field' => ['value' => 'filter']]]],
            'should' => [['term' => ['field' => ['value' => 'should']]]],
            'must_not' => [['term' => ['field' => ['value' => 'must_not']]]],
            'boost' => 2.0,
            '_name' => 'test',
            'minimum_should_match' => '1',
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['bool' => []],
            (new BoolQuery())->toQuery()
        );
    }

    public function testFullQuery(): void
    {
        $query = new BoolQuery();
        $query->setBoost(2.0);
        $query->setQueryName('test');
        $query->addMust(new TermQuery('field', 'must'));
        $query->addFilter(new TermQuery('field', 'filter'));
        $query->addShould(new TermQuery('field', 'should'));
        $query->addMustNot(new TermQuery('field', 'must_not'));
        $query->setMinimumShouldMatch('1');

        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
