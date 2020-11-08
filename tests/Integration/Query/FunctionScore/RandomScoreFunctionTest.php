<?php

declare(strict_types=1);

namespace EsQb\Integration\Query\FunctionScore;

use EsQb\Integration\ArrayQueryWrapper;
use EsQb\Integration\EsQbIntegrationTest;
use EsQb\Unit\Query\FunctionScore\RandomScoreFunctionTest as UnitRandomScoreFunctionTest;

class RandomScoreFunctionTest extends EsQbIntegrationTest
{
    public function testBase(): void
    {
        $this->assertValidQuery(
            new ArrayQueryWrapper(['function_score' => UnitRandomScoreFunctionTest::baseFunction()])
        );
        $this->assertValidQuery(
            new ArrayQueryWrapper(['function_score' => UnitRandomScoreFunctionTest::FULL_FUNCTION])
        );
    }
}
