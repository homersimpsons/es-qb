<?php

declare(strict_types=1);

namespace EsQb\Integration;

use EsQb\Query\AbstractQuery;
use PHPUnit\Framework\ExpectationFailedException;

use function strtok;

use const PHP_EOL;

class AssertTest extends EsQbIntegrationTest
{
    public function testInvalidQuery(): void
    {
        try {
            $this->assertValidQuery(new class extends AbstractQuery {
                /**
                 * {@inheritDoc}
                 */
                protected function doToQuery(): array
                {
                    return ['invalid_query' => []];
                }
            });
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                'Invalid Query : {"invalid_query":[]}',
                strtok($e->getMessage(), PHP_EOL) // Extract only the first line
            );

            return;
        }

        $this->fail('This test should have failed !');
    }
}
