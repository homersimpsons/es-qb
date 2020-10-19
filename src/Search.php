<?php

declare(strict_types=1);

namespace EsQb;

use EsQb\Query\AbstractQuery;

use function assert;
use function implode;
use function is_array;
use function is_string;

final class Search
{
    public const DEFAULT_ALLOW_NO_INDICES              = true;
    public const DEFAULT_ALLOW_PARTIAL_SEARCH_RESULTS  = true;
    public const DEFAULT_BATCHED_REDUCE_SIZE           = 512;
    public const DEFAULT_CCS_MINIMIZE_ROUNDTRIPS       = true;
    public const DEFAULT_EXPAND_WILDCARDS              = 'open';
    public const DEFAULT_EXPLAIN                       = false;
    public const DEFAULT_FROM                          = 0;
    public const DEFAULT_IGNORE_THROTTLED              = true;
    public const DEFAULT_IGNORE_UNAVAILABLE            = false;
    public const DEFAULT_MAX_CONCURRENT_SHARD_REQUESTS = 5;
    public const DEFAULT_REST_TOTAL_HITS_AS_INT        = false;
    public const DEFAULT_SEARCH_TYPE                   = 'query_then_fetch';
    public const DEFAULT_SIZE                          = 10;
    public const DEFAULT_SOURCE                        = true;
    public const DEFAULT_TERMINATE_AFTER               = 0;
    public const DEFAULT_TRACK_SCORES                  = false;
    public const DEFAULT_TRACK_TOTAL_HITS              = 10000;
    public const DEFAULT_TYPED_KEYS                    = true;
    public const DEFAULT_VERSION                       = false;

    private string $target;
    private bool $allowNoIndices            = self::DEFAULT_ALLOW_NO_INDICES;
    private bool $allowPartialSearchResults = self::DEFAULT_ALLOW_PARTIAL_SEARCH_RESULTS;
    private int $batchedReduceSize          = self::DEFAULT_BATCHED_REDUCE_SIZE;
    private bool $ccsMinimizeRoundtrips     = self::DEFAULT_CCS_MINIMIZE_ROUNDTRIPS;
    /**
     * @var string|array<string|array<string, string>>|null
     * @phpstan-var string|array<string|array{field: string, format?: string}>|null
     */
    private $docvalueFields                 = null;
    private string $expandWildcards         = self::DEFAULT_EXPAND_WILDCARDS;
    private bool $explain                   = self::DEFAULT_EXPLAIN;
    private int $from                       = self::DEFAULT_FROM;
    private bool $ignoreThrottled           = self::DEFAULT_IGNORE_THROTTLED;
    private bool $ignoreUnavailable         = self::DEFAULT_IGNORE_UNAVAILABLE;
    private int $maxConcurrentShardRequests = self::DEFAULT_MAX_CONCURRENT_SHARD_REQUESTS;
    private ?int $preFilterShardSize        = null;
    private ?string $preference             = null;
    private ?string $q                      = null;
    private ?bool $requestCache             = null;
    private bool $restTotalHitsAsInt        = self::DEFAULT_REST_TOTAL_HITS_AS_INT;
    private ?string $routing                = null;
    private ?string $scroll                 = null;
    private string $searchType              = self::DEFAULT_SEARCH_TYPE;
    private ?bool $seqNoPrimaryTerm         = null;
    private int $size                       = self::DEFAULT_SIZE;
    private ?string $sort                   = null;
    /** @var bool|string|string[] */
    private $source = self::DEFAULT_SOURCE;
    /** @var string[]|null */
    private ?array $sourceExcludes = null;
    /** @var string[]|null */
    private ?array $sourceIncludes = null;
    /** @var string|string[]|null */
    private $stats                = null;
    private ?string $storedFields = null;
    private ?string $suggestField = null;
    private ?string $suggestText  = null;
    private int $terminateAfter   = self::DEFAULT_TERMINATE_AFTER;
    private ?string $timeout      = null;
    private bool $trackScores     = self::DEFAULT_TRACK_SCORES;
    /** @var int|bool */
    private $trackTotalHits = self::DEFAULT_TRACK_TOTAL_HITS;
    private bool $typedKeys = self::DEFAULT_TYPED_KEYS;
    private bool $version   = self::DEFAULT_VERSION;
    // Body parameters
    /** @var array<array<string, float>> */
    private array $indicesBoost   = [];
    private ?float $minScore      = null;
    private ?AbstractQuery $query = null;

    public function __construct(string $target)
    {
        $this->target = $target;
    }

    /**
     * @return array<string, mixed>
     */
    public function toSearch(bool $preferGet = false): array
    {
        $search = ['index' => $this->target];
        $body   = [];
        if ($preferGet) {
            $preferred = &$search;
        } else {
            $preferred = &$body;
        }

        Utils::printIfNotDefault(
            $search,
            'allow_no_indices',
            $this->getAllowNoIndices(),
            self::DEFAULT_ALLOW_NO_INDICES
        );
        Utils::printIfNotDefault(
            $search,
            'allow_partial_search_results',
            $this->getAllowPartialSearchResults(),
            self::DEFAULT_ALLOW_PARTIAL_SEARCH_RESULTS
        );
        Utils::printIfNotDefault(
            $search,
            'batched_reduce_size',
            $this->getBatchedReduceSize(),
            self::DEFAULT_BATCHED_REDUCE_SIZE
        );
        Utils::printIfNotDefault(
            $search,
            'ccs_minimize_roundtrips',
            $this->getCcsMinimizeRoundtrips(),
            self::DEFAULT_CCS_MINIMIZE_ROUNDTRIPS
        );
        $docvalueFields = $this->getDocvalueFields();
        if ($docvalueFields !== null) {
            if (is_string($docvalueFields)) {
                Utils::printIfNotDefault($search, 'docvalue_fields', $docvalueFields, null);
            } else {
                assert(is_array($docvalueFields));
                Utils::printIfNotDefault($body, 'docvalue_fields', $docvalueFields, null);
            }
        }

        Utils::printIfNotDefault(
            $search,
            'expand_wildcards',
            $this->getExpandWildcards(),
            self::DEFAULT_EXPAND_WILDCARDS
        );
        Utils::printIfNotDefault($preferred, 'explain', $this->getExplain(), self::DEFAULT_EXPLAIN);
        Utils::printIfNotDefault($preferred, 'from', $this->getFrom(), self::DEFAULT_FROM);
        Utils::printIfNotDefault(
            $search,
            'ignore_throttled',
            $this->getIgnoreThrottled(),
            self::DEFAULT_IGNORE_THROTTLED
        );
        Utils::printIfNotDefault(
            $search,
            'ignore_unavailable',
            $this->getIgnoreUnavailable(),
            self::DEFAULT_IGNORE_UNAVAILABLE
        );
        Utils::printIfNotDefault(
            $search,
            'max_concurrent_shard_requests',
            $this->getMaxConcurrentShardRequests(),
            self::DEFAULT_MAX_CONCURRENT_SHARD_REQUESTS
        );
        Utils::printIfNotDefault($search, 'pre_filter_shard_size', $this->getPreFilterShardSize(), null);
        Utils::printIfNotDefault($search, 'preference', $this->getPreference(), null);
        Utils::printIfNotDefault($search, 'q', $this->getQ(), null);
        Utils::printIfNotDefault($search, 'request_cache', $this->getRequestCache(), null);
        Utils::printIfNotDefault(
            $search,
            'rest_total_hits_as_int',
            $this->getRestTotalHitsAsInt(),
            self::DEFAULT_REST_TOTAL_HITS_AS_INT
        );
        Utils::printIfNotDefault($search, 'routing', $this->getRouting(), null);
        Utils::printIfNotDefault($search, 'scroll', $this->getScroll(), null);
        Utils::printIfNotDefault($search, 'search_type', $this->getSearchType(), self::DEFAULT_SEARCH_TYPE);
        Utils::printIfNotDefault($preferred, 'seq_no_primary_term', $this->getSeqNoPrimaryTerm(), null);
        Utils::printIfNotDefault($preferred, 'size', $this->getSize(), self::DEFAULT_SIZE);
        Utils::printIfNotDefault($search, 'sort', $this->getSort(), null);

        $source         = $this->getSource();
        $sourceExludes  = $this->getSourceExcludes();
        $sourceIncludes = $this->getSourceIncludes();
        if ($preferGet && ! is_array($source)) {
            Utils::printIfNotDefault($search, '_source', $source, self::DEFAULT_SOURCE);
            Utils::printIfNotDefault($search, '_source_excludes', implode(',', $sourceExludes ?? []), '');
            Utils::printIfNotDefault($search, '_source_includes', implode(',', $sourceIncludes ?? []), '');
        } else {
            if (! empty($sourceIncludes) || ! empty($sourceExludes)) {
                $body['_source'] = ['excludes' => $sourceExludes, 'includes' => $sourceIncludes];
            } else {
                Utils::printIfNotDefault($body, '_source', $source, self::DEFAULT_SOURCE);
            }
        }

        $stats = $this->getStats();
        if ($stats !== null) {
            if (is_string($stats)) {
                Utils::printIfNotDefault($search, 'stats', $stats, null);
            } else {
                assert(is_array($stats));
                Utils::printIfNotDefault($body, 'stats', $stats, null);
            }
        }

        Utils::printIfNotDefault($search, 'stored_fields', $this->getStoredFields(), null);
        Utils::printIfNotDefault($search, 'suggest_field', $this->getSuggestField(), null);
        Utils::printIfNotDefault($search, 'suggest_text', $this->getSuggestText(), null);
        Utils::printIfNotDefault(
            $preferred,
            'terminate_after',
            $this->getTerminateAfter(),
            self::DEFAULT_TERMINATE_AFTER
        );
        Utils::printIfNotDefault($preferred, 'timeout', $this->getTimeout(), null);
        Utils::printIfNotDefault($search, 'track_scores', $this->getTrackScores(), self::DEFAULT_TRACK_SCORES);
        Utils::printIfNotDefault(
            $search,
            'track_total_hits',
            $this->getTrackTotalHits(),
            self::DEFAULT_TRACK_TOTAL_HITS
        );
        Utils::printIfNotDefault($search, 'typed_keys', $this->getTypedKeys(), self::DEFAULT_TYPED_KEYS);
        Utils::printIfNotDefault($preferred, 'version', $this->getVersion(), self::DEFAULT_VERSION);

        // Body Only
        Utils::printIfNotDefault($body, 'indices_boost', $this->getIndicesBoost(), []);
        Utils::printIfNotDefault($body, 'min_score', $this->getMinScore(), null);

        $query = $this->getQuery();
        if ($query !== null) {
            $body['query'] = $query->toQuery();
        }

        if (! empty($body)) {
            $search['body'] = $body;
        }

        return $search;
    }

    public function getAllowNoIndices(): bool
    {
        return $this->allowNoIndices;
    }

    public function setAllowNoIndices(bool $allowNoIndices): void
    {
        $this->allowNoIndices = $allowNoIndices;
    }

    public function getAllowPartialSearchResults(): bool
    {
        return $this->allowPartialSearchResults;
    }

    public function setAllowPartialSearchResults(bool $allowPartialSearchResults): void
    {
        $this->allowPartialSearchResults = $allowPartialSearchResults;
    }

    public function getBatchedReduceSize(): int
    {
        return $this->batchedReduceSize;
    }

    public function setBatchedReduceSize(int $batchedReduceSize): void
    {
        $this->batchedReduceSize = $batchedReduceSize;
    }

    public function getCcsMinimizeRoundtrips(): bool
    {
        return $this->ccsMinimizeRoundtrips;
    }

    public function setCcsMinimizeRoundtrips(bool $ccsMinimizeRoundtrips): void
    {
        $this->ccsMinimizeRoundtrips = $ccsMinimizeRoundtrips;
    }

    /**
     * @return string|array<string|array<string, string>>|null
     *
     * @phpstan-return string|array<string|array{field: string, format?: string}>|null
     */
    public function getDocvalueFields()
    {
        return $this->docvalueFields;
    }

    /**
     * @param string|array<string|array<string, string>>|null $docvalueFields
     *
     * @phpstan-param string|array<string|array{field: string, format?: string}>|null $docvalueFields
     */
    public function setDocvalueFields($docvalueFields): void
    {
        $this->docvalueFields = $docvalueFields;
    }

    public function getExpandWildcards(): string
    {
        return $this->expandWildcards;
    }

    public function setExpandWildcards(string $expandWildcards): void
    {
        $this->expandWildcards = $expandWildcards;
    }

    public function getExplain(): bool
    {
        return $this->explain;
    }

    public function setExplain(bool $explain): void
    {
        $this->explain = $explain;
    }

    public function getFrom(): int
    {
        return $this->from;
    }

    public function setFrom(int $from): void
    {
        $this->from = $from;
    }

    public function getIgnoreThrottled(): bool
    {
        return $this->ignoreThrottled;
    }

    public function setIgnoreThrottled(bool $ignoreThrottled): void
    {
        $this->ignoreThrottled = $ignoreThrottled;
    }

    public function getIgnoreUnavailable(): bool
    {
        return $this->ignoreUnavailable;
    }

    public function setIgnoreUnavailable(bool $ignoreUnavailable): void
    {
        $this->ignoreUnavailable = $ignoreUnavailable;
    }

    public function getMaxConcurrentShardRequests(): int
    {
        return $this->maxConcurrentShardRequests;
    }

    public function setMaxConcurrentShardRequests(int $maxConcurrentShardRequests): void
    {
        $this->maxConcurrentShardRequests = $maxConcurrentShardRequests;
    }

    public function getPreFilterShardSize(): ?int
    {
        return $this->preFilterShardSize;
    }

    public function setPreFilterShardSize(?int $preFilterShardSize): void
    {
        $this->preFilterShardSize = $preFilterShardSize;
    }

    public function getPreference(): ?string
    {
        return $this->preference;
    }

    public function setPreference(?string $preference): void
    {
        $this->preference = $preference;
    }

    public function getQ(): ?string
    {
        return $this->q;
    }

    public function setQ(?string $q): void
    {
        $this->q = $q;
    }

    public function getRequestCache(): ?bool
    {
        return $this->requestCache;
    }

    public function setRequestCache(?bool $requestCache): void
    {
        $this->requestCache = $requestCache;
    }

    public function getRestTotalHitsAsInt(): bool
    {
        return $this->restTotalHitsAsInt;
    }

    public function setRestTotalHitsAsInt(bool $restTotalHitsAsInt): void
    {
        $this->restTotalHitsAsInt = $restTotalHitsAsInt;
    }

    public function getRouting(): ?string
    {
        return $this->routing;
    }

    public function setRouting(?string $routing): void
    {
        $this->routing = $routing;
    }

    public function getScroll(): ?string
    {
        return $this->scroll;
    }

    public function setScroll(?string $scroll): void
    {
        $this->scroll = $scroll;
    }

    public function getSearchType(): string
    {
        return $this->searchType;
    }

    public function setSearchType(string $searchType): void
    {
        $this->searchType = $searchType;
    }

    public function getSeqNoPrimaryTerm(): ?bool
    {
        return $this->seqNoPrimaryTerm;
    }

    public function setSeqNoPrimaryTerm(?bool $seqNoPrimaryTerm): void
    {
        $this->seqNoPrimaryTerm = $seqNoPrimaryTerm;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function setSort(?string $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return bool|string|string[]
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set _source and reset source includes and excludes to default
     *
     * @param bool|string|string[] $source
     */
    public function setSource($source): void
    {
        $this->source         = $source;
        $this->sourceExcludes = null;
        $this->sourceIncludes = null;
    }

    /**
     * @return string[]|null
     */
    public function getSourceExcludes(): ?array
    {
        return $this->sourceExcludes;
    }

    /**
     * Set source excludes and reset _source to default
     *
     * @param string[]|null $sourceExcludes
     */
    public function setSourceExcludes(?array $sourceExcludes): void
    {
        $this->sourceExcludes = $sourceExcludes;
        $this->source         = self::DEFAULT_SOURCE;
    }

    /**
     * Set source includes and reset _source to default
     *
     * @return string[]|null
     */
    public function getSourceIncludes(): ?array
    {
        return $this->sourceIncludes;
    }

    /**
     * @param string[]|null $sourceIncludes
     */
    public function setSourceIncludes(?array $sourceIncludes): void
    {
        $this->sourceIncludes = $sourceIncludes;
        $this->source         = self::DEFAULT_SOURCE;
    }

    /**
     * @return string|string[]|null
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @param string|string[]|null $stats
     */
    public function setStats($stats): void
    {
        $this->stats = $stats;
    }

    public function getStoredFields(): ?string
    {
        return $this->storedFields;
    }

    public function setStoredFields(?string $storedFields): void
    {
        $this->storedFields = $storedFields;
    }

    public function getSuggestField(): ?string
    {
        return $this->suggestField;
    }

    public function setSuggestField(?string $suggestField): void
    {
        $this->suggestField = $suggestField;
    }

    public function getSuggestText(): ?string
    {
        return $this->suggestText;
    }

    public function setSuggestText(?string $suggestText): void
    {
        $this->suggestText = $suggestText;
    }

    public function getTerminateAfter(): int
    {
        return $this->terminateAfter;
    }

    public function setTerminateAfter(int $terminateAfter): void
    {
        $this->terminateAfter = $terminateAfter;
    }

    public function getTimeout(): ?string
    {
        return $this->timeout;
    }

    public function setTimeout(?string $timeout): void
    {
        $this->timeout = $timeout;
    }

    public function getTrackScores(): bool
    {
        return $this->trackScores;
    }

    public function setTrackScores(bool $trackScores): void
    {
        $this->trackScores = $trackScores;
    }

    /**
     * @return bool|int
     */
    public function getTrackTotalHits()
    {
        return $this->trackTotalHits;
    }

    /**
     * @param bool|int $trackTotalHits
     */
    public function setTrackTotalHits($trackTotalHits): void
    {
        $this->trackTotalHits = $trackTotalHits;
    }

    public function getTypedKeys(): bool
    {
        return $this->typedKeys;
    }

    public function setTypedKeys(bool $typedKeys): void
    {
        $this->typedKeys = $typedKeys;
    }

    public function getVersion(): bool
    {
        return $this->version;
    }

    public function setVersion(bool $version): void
    {
        $this->version = $version;
    }

    /**
     * @return array<array<string, float>>
     */
    public function getIndicesBoost(): array
    {
        return $this->indicesBoost;
    }

    /**
     * @param array<array<string, float>> $indicesBoost
     */
    public function setIndicesBoost(array $indicesBoost): void
    {
        $this->indicesBoost = $indicesBoost;
    }

    public function getMinScore(): ?float
    {
        return $this->minScore;
    }

    public function setMinScore(?float $minScore): void
    {
        $this->minScore = $minScore;
    }

    public function getQuery(): ?AbstractQuery
    {
        return $this->query;
    }

    public function setQuery(?AbstractQuery $query): void
    {
        $this->query = $query;
    }
}
