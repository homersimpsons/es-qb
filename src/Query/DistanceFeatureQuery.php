<?php

declare(strict_types=1);

namespace EsQb\Query;

final class DistanceFeatureQuery extends AbstractQuery
{
    private string $field;
    private string $origin;
    private string $pivot;

    /**
     * @TODO $origin can get more types than just string
     */
    public function __construct(string $field, string $origin, string $pivot)
    {
        $this->field  = $field;
        $this->origin = $origin;
        $this->pivot  = $pivot;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = ['field' => $this->getField(), 'pivot' => $this->getPivot(), 'origin' => $this->getOrigin()];
        $this->printBoostAndQueryName($innerQuery);

        return ['distance_feature' => $innerQuery];
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getPivot(): string
    {
        return $this->pivot;
    }
}
