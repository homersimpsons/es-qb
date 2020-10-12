<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\GeoPoint;
use EsQb\Utils;

use function array_map;

class GeoPolygonQuery extends AbstractQuery
{
    public const DEFAULT_VALIDATION_METHOD = 'STRICT';

    private string $field;
    /** @var GeoPoint[] */
    private array $points;
    private string $validationMethod = self::DEFAULT_VALIDATION_METHOD;
    private ?bool $ignoreUnmapped    = null;

    /**
     * @param GeoPoint[] $points
     */
    public function __construct(string $field, array $points)
    {
        $this->field  = $field;
        $this->points = $points;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            $this->field => [
                'points' => array_map(
                    static fn (GeoPoint $point) => ['lat' => $point->getLat(), 'lon' => $point->getLon()],
                    $this->points
                ),
            ],
        ];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault(
            $innerQuery,
            'validation_method',
            $this->getValidationMethod(),
            self::DEFAULT_VALIDATION_METHOD
        );
        Utils::printIfNotDefault($innerQuery, 'ignore_unmapped', $this->getIgnoreUnmapped(), null);

        return ['geo_polygon' => $innerQuery];
    }

    public function getValidationMethod(): string
    {
        return $this->validationMethod;
    }

    public function setValidationMethod(string $validationMethod): void
    {
        $this->validationMethod = $validationMethod;
    }

    public function getIgnoreUnmapped(): ?bool
    {
        return $this->ignoreUnmapped;
    }

    public function setIgnoreUnmapped(?bool $ignoreUnmapped): void
    {
        $this->ignoreUnmapped = $ignoreUnmapped;
    }
}
