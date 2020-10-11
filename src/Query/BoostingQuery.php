<?php

declare(strict_types=1);

namespace EsQb\Query;

final class BoostingQuery extends AbstractQuery
{
    private AbstractQuery $positive;
    private AbstractQuery $negative;
    private float $negativeBoost;

    public function __construct(AbstractQuery $positive, AbstractQuery $negative, float $negativeBoost)
    {
        $this->positive      = $positive;
        $this->negative      = $negative;
        $this->negativeBoost = $negativeBoost;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            'positive' => $this->positive->doToQuery(),
            'negative' => $this->negative->doToQuery(),
            'negative_boost' => $this->negativeBoost,
        ];
        $this->printBoostAndQueryName($innerQuery);

        return ['boosting' => $innerQuery];
    }
}
