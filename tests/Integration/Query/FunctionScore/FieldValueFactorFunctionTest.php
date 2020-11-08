<?php

declare(strict_types=1);

namespace EsQb\Integration\Query\FunctionScore;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\FunctionScore\FieldValueFactorFunctionTest as UnitFieldValueFactorFunctionTest;

class FieldValueFactorFunctionTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(
            new ArrayQueryWrapper(['function_score' => UnitFieldValueFactorFunctionTest::FULL_FUNCTION])
        );
    }
}
