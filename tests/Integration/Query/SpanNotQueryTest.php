<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\SpanNotQueryTest as UnitSpanNotQueryTest;

class SpanNotQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $fullQueryWithDist = UnitSpanNotQueryTest::FULL_QUERY;
        unset($fullQueryWithDist['span_not']['pre'], $fullQueryWithDist['span_not']['post']);
        $this->assertValidQuery(new ArrayQueryWrapper($fullQueryWithDist));
        $fullQueryWithPreAndPost = UnitSpanNotQueryTest::FULL_QUERY;
        unset($fullQueryWithPreAndPost['span_not']['dist']);
        $this->assertValidQuery(new ArrayQueryWrapper($fullQueryWithPreAndPost));
    }
}
