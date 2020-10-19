<?php

declare(strict_types=1);

namespace EsQb\Query;

use EsQb\GeoPoint;
use EsQb\Utils;

final class GeoDistanceQuery extends AbstractQuery
{
    public const DEFAULT_DISTANCE_TYPE     = 'arc';
    public const DEFAULT_VALIDATION_METHOD = 'STRICT';

    private string $field;
    private GeoPoint $origin;
    private string $distance;
    private string $distanceType     = self::DEFAULT_DISTANCE_TYPE;
    private string $validationMethod = self::DEFAULT_VALIDATION_METHOD;
    private ?bool $ignoreUnmapped    = null;

    public function __construct(string $field, GeoPoint $origin, string $distance)
    {
        $this->field    = $field;
        $this->origin   = $origin;
        $this->distance = $distance;
    }

    /**
     * {@inheritDoc}
     */
    protected function doToQuery(): array
    {
        $innerQuery = [
            $this->field =>
            [
                'lat' => $this->origin->getLat(),
                'lon' => $this->origin->getLon(),
            ],
            'distance' => $this->distance,
        ];
        $this->printBoostAndQueryName($innerQuery);
        Utils::printIfNotDefault($innerQuery, 'distance_type', $this->getDistanceType(), self::DEFAULT_DISTANCE_TYPE);
        Utils::printIfNotDefault(
            $innerQuery,
            'validation_method',
            $this->getValidationMethod(),
            self::DEFAULT_VALIDATION_METHOD
        );
        Utils::printIfNotDefault($innerQuery, 'ignore_unmapped', $this->getIgnoreUnmapped(), null);

        return ['geo_distance' => $innerQuery];
    }

    public function getDistanceType(): string
    {
        return $this->distanceType;
    }

    public function setDistanceType(string $distanceType): void
    {
        $this->distanceType = $distanceType;
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
