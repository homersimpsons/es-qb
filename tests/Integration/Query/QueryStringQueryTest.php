<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\QueryStringQueryTest as UnitQueryStringQueryTest;

class QueryStringQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $fullQueryWithoutDefault = UnitQueryStringQueryTest::FULL_QUERY;
        unset($fullQueryWithoutDefault['query_string']['default_field']);
        $this->assertValidQuery(new ArrayQueryWrapper($fullQueryWithoutDefault));
        $fullQueryWithoutFields = UnitQueryStringQueryTest::FULL_QUERY;
        unset($fullQueryWithoutFields['query_string']['fields']);
        $this->assertValidQuery(new ArrayQueryWrapper($fullQueryWithoutFields));
    }
}
