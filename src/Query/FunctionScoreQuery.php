<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\Query\FunctionScore\AbstractScoreFunction;
use EsQb\Query\FunctionScore\FunctionScoreFunction;
use EsQb\Utils;

use function array_map;

final class FunctionScoreQuery extends AbstractQuery
{
    public const DEFAULT_WEIGHT     = 1.0;
    public const DEFAULT_SCORE_MODE = 'multiply';
    public const DEFAULT_BOOST_MODE = 'multiply';

    private AbstractQuery $query;
    /** @var FunctionScoreFunction[] */
    private array $functions  = [];
    private string $scoreMode = self::DEFAULT_SCORE_MODE;
    private string $boostMode = self::DEFAULT_BOOST_MODE;
    private ?float $maxBoost  = null;
    private ?float $minScore  = null;

    public function __construct(
        AbstractQuery $query,
        AbstractScoreFunction $function,
        float $functionWeight = self::DEFAULT_WEIGHT,
        ?AbstractQuery $functionFilter = null
    ) {
        $this->query = $query;
        $this->addFunction($function, $functionWeight, $functionFilter);
    }

    public function addFunction(
        AbstractScoreFunction $function,
        float $weight = self::DEFAULT_WEIGHT,
        ?AbstractQuery $filter = null
    ): void {
        $this->functions[] = new FunctionScoreFunction($function, $weight, $filter);
    }

    public function setScoreMode(string $scoreMode): void
    {
        $this->scoreMode = $scoreMode;
    }

    public function setBoostMode(string $boostMode): void
    {
        $this->boostMode = $boostMode;
    }

    public function setMaxBoost(?float $maxBoost): void
    {
        $this->maxBoost = $maxBoost;
    }

    public function setMinScore(?float $minScore): void
    {
        $this->minScore = $minScore;
    }

    /**
     * @inheritDoc
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            'query' => $this->query->doToQuery(),
            'functions' => array_map(static function (FunctionScoreFunction $function) {
                $functionArray = $function->getFunction()->toFunction();
                Utils::printIfNotDefault($functionArray, 'weight', $function->getWeight(), self::DEFAULT_WEIGHT);
                $filter = $function->getFilter();
                if ($filter !== null) {
                    $functionArray['filter'] = $filter->toQuery();
                }

                return $functionArray;
            }, $this->functions),
        ];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'score_mode', $this->scoreMode, self::DEFAULT_SCORE_MODE);
        Utils::printIfNotDefault($innerQuery, 'boost_mode', $this->boostMode, self::DEFAULT_BOOST_MODE);
        Utils::printIfNotDefault($innerQuery, 'max_boost', $this->maxBoost, null);
        Utils::printIfNotDefault($innerQuery, 'min_score', $this->minScore, null);

        return ['function_score' => $innerQuery];
    }
}
