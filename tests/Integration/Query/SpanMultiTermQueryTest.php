<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\SpanMultiTermQueryTest as UnitSpanMultiTermQueryTest;

class SpanMultiTermQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitSpanMultiTermQueryTest::FULL_QUERY));
    }
}
