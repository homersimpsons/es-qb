<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Utils;

final class RangeQuery extends AbstractQuery implements MultiTermQuery
{
    public const RELATION = 'INTERSECTS';

    private string $field;
    private ?string $gt       = null;
    private ?string $gte      = null;
    private ?string $lt       = null;
    private ?string $lte      = null;
    private ?string $format   = null;
    private string $relation  = self::RELATION;
    private ?string $timeZone = null;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = [];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'gt', $this->getGt(), null);
        Utils::printIfNotDefault($innerQuery, 'gte', $this->getGte(), null);
        Utils::printIfNotDefault($innerQuery, 'lt', $this->getLt(), null);
        Utils::printIfNotDefault($innerQuery, 'lte', $this->getLte(), null);
        Utils::printIfNotDefault($innerQuery, 'format', $this->getFormat(), null);
        Utils::printIfNotDefault($innerQuery, 'relation', $this->getRelation(), self::RELATION);
        Utils::printIfNotDefault($innerQuery, 'time_zone', $this->getTimeZone(), null);

        return ['range' => [$this->field => $innerQuery]];
    }

    public function getGt(): ?string
    {
        return $this->gt;
    }

    public function setGt(?string $gt): void
    {
        $this->gt = $gt;
    }

    public function getGte(): ?string
    {
        return $this->gte;
    }

    public function setGte(?string $gte): void
    {
        $this->gte = $gte;
    }

    public function getLt(): ?string
    {
        return $this->lt;
    }

    public function setLt(?string $lt): void
    {
        $this->lt = $lt;
    }

    public function getLte(): ?string
    {
        return $this->lte;
    }

    public function setLte(?string $lte): void
    {
        $this->lte = $lte;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): void
    {
        $this->format = $format;
    }

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): void
    {
        $this->relation = $relation;
    }

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function setTimeZone(?string $timeZone): void
    {
        $this->timeZone = $timeZone;
    }
}
