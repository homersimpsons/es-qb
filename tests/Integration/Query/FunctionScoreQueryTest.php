<?php

declare(strict_types=1);

namespace EsQb\Integration\Query;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\FunctionScoreQueryTest as UnitFunctionScoreQueryTest;

class FunctionScoreQueryTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(new ArrayQueryWrapper(UnitFunctionScoreQueryTest::FULL_QUERY));
    }
}
