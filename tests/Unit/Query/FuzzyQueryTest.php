<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\FuzzyQuery;
use PHPUnit\Framework\TestCase;

class FuzzyQueryTest extends TestCase
{
    public const FULL_QUERY = [
        'fuzzy' => [
            'field' => [
                'value' => 'query',
                '_name' => 'queryName',
                'boost' => 2.0,
                'fuzziness' => '0',
                'max_expansions' => 1,
                'prefix_length' => 1,
                'transpositions' => true,
                'rewrite' => 'constant_score_boolean',
            ],
        ],
    ];

    public function testBase(): void
    {
        $this->assertEquals(
            ['fuzzy' => ['field' => ['value' => 'query']]],
            (new FuzzyQuery('field', 'query'))->toQuery()
        );
    }

    public function testWithAll(): void
    {
        $query = new FuzzyQuery('field', 'query');
        $query->setQueryName('queryName');
        $query->setBoost(2.0);
        $query->setFuzziness('0');
        $query->setMaxExpansions(1);
        $query->setPrefixLength(1);
        $query->setTranspositions(true);
        $query->setRewrite('constant_score_boolean');
        $this->assertEquals(self::FULL_QUERY, $query->toQuery());
    }
}
