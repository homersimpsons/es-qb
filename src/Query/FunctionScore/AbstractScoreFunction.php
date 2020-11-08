<?php

declare(strict_types=1);

namespace EsQb\Query\FunctionScore;

// phpcs:ignore SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming.SuperfluousPrefix
abstract class AbstractScoreFunction
{
    /**
     * @return array<string, mixed>
     */
    final public function toFunction(): array
    {
        return $this->doToFunction();
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function doToFunction(): array;
}
