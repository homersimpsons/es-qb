<?php

declare(strict_types=1);

namespace EsQb\Unit\Query;

use EsQb\Query\AbstractQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AbstractQueryTest extends TestCase
{
    public function testDefaults(): void
    {
        $query = $this->getMockForAbstractClass(AbstractQuery::class);
        $this->assertEquals(1.0, $query->getBoost());
        $this->assertNull($query->getQueryName());
    }

    public function testNegativeBoost(): void
    {
        $query = $this->getMockForAbstractClass(AbstractQuery::class);
        $this->expectException(InvalidArgumentException::class);
        $query->setBoost(-1.);
    }

    public function testBoost(): void
    {
        $query = $this->getMockForAbstractClass(AbstractQuery::class);
        $this->assertEquals(1.0, $query->getBoost());
        $query->setBoost(2.0);
        $this->assertEquals(2.0, $query->getBoost());
    }

    public function testQueryName(): void
    {
        $query = $this->getMockForAbstractClass(AbstractQuery::class);
        $this->assertNull($query->getQueryName());
        $query->setQueryName('test');
        $this->assertEquals('test', $query->getQueryName());
    }
}
