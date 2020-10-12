<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\TermsQuery;
use PHPUnit\Framework\TestCase;

class TermsQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'terms' => [
            'field' => ['value'],
            '_name' => 'queryName',
            'boost' => 2.0,
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['terms' => ['field' => ['value']]],
            (new TermsQuery('field', ['value']))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new TermsQuery('field', ['value']);
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
