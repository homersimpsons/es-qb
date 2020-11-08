<?php

declare(strict_types=1);

namespace EsQb\Integration\Query\FunctionScore;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\FunctionScore\ExponentialDecayFunctionTest as UnitExponentialDecayFunctionTest;

class ExponentialDecayFunctionTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(
            new ArrayQueryWrapper(['function_score' => UnitExponentialDecayFunctionTest::FULL_FUNCTION])
        );
    }
}
