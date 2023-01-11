<?php

declare(strict_types=1);

namespace App\Formatters;

use Exception;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\Utils;
use Throwable;

class JsonFormatter extends NormalizerFormatter
{
    const BATCH_MODE_JSON = 1;
    const BATCH_MODE_NEWLINES = 2;

    protected $batchMode;
    protected $appendNewline;
    protected $maxNormalizeItemCount;
    protected $ignoreEmptyContextAndExtra;

    /**
     * @var bool
     */
    protected $includeStacktraces;

    /**
     * @param int $batchMode
     * @param bool $appendNewline
     * @param bool $ignoreEmptyContextAndExtra
     * @param int $maxNormalizeItemCount
     * @param bool $includeStacktraces
     */
    public function __construct($batchMode = self::BATCH_MODE_JSON, $appendNewline = true,
                                bool $ignoreEmptyContextAndExtra = false, int $maxNormalizeItemCount = 10000,
                                $includeStacktraces = false)
    {
        parent::__construct();

        $this->batchMode = $batchMode;
        $this->appendNewline = $appendNewline;
        $this->ignoreEmptyContextAndExtra = $ignoreEmptyContextAndExtra;
        $this->maxNormalizeItemCount = $maxNormalizeItemCount;
        $this->includeStacktraces = $includeStacktraces;
    }

    /**
     * @return int
     */
    public function getBatchMode()
    {
        return $this->batchMode;
    }

    /**
     * @param array $records
     * @return string
     */
    public function formatBatch(array $records)
    {
        switch ($this->batchMode) {
            case static::BATCH_MODE_NEWLINES:
                return $this->formatBatchNewlines($records);

            case static::BATCH_MODE_JSON:
            default:
                return $this->formatBatchJson($records);
        }
    }

    /**
     * Use new lines to separate records instead of a
     * JSON-encoded array.
     *
     * @param array $records
     * @return string
     */
    protected function formatBatchNewlines(array $records)
    {
        $instance = $this;

        $oldNewline = $this->appendNewline;
        $this->appendNewline = false;
        array_walk($records, function (&$value, $key) use ($instance) {
            $value = $instance->format($value);
        });
        $this->appendNewline = $oldNewline;

        return implode("\n", $records);
    }

    /**
     * @param array $record
     * @return string
     */
    public function format(array $record): string
    {
        $normalized = $this->normalize($record);

        if (isset($normalized['context']) && $normalized['context'] === []) {
            if ($this->ignoreEmptyContextAndExtra) {
                unset($normalized['context']);
            } else {
                $normalized['context'] = new \stdClass;
            }
        }
        if (isset($normalized['extra']) && $normalized['extra'] === []) {
            if ($this->ignoreEmptyContextAndExtra) {
                unset($normalized['extra']);
            } else {
                $normalized['extra'] = new \stdClass;
            }
        }

        return $this->toJson($normalized, true) . ($this->appendNewline ? "\n" : '');
    }

    /**
     * Normalizes given $data.
     *
     * @param mixed $data
     *
     * @param int $depth
     * @return mixed
     */
    protected function normalize($data, $depth = 0)
    {
        if ($depth > 9) {
            return 'Over 9 levels deep, aborting normalization';
        }

        $maxItemCount = $this->getMaxNormalizeItemCount();

        if (is_array($data)) {
            $normalized = array();

            $count = 1;
            foreach ($data as $key => $value) {
                if ($count++ > $maxItemCount) {
                    $normalized['...'] = 'Over ' . $maxItemCount . ' items (' . count($data) . ' total), aborting normalization';
                    break;
                }

                $normalized[$key] = $this->normalize($value, $depth + 1);
            }

            return $normalized;
        }

        if ($data instanceof Exception || $data instanceof Throwable) {
            return $this->normalizeException($data);
        }

        if (is_object($data)) {
            if ($data instanceof Throwable) {
                return $this->normalizeException($data);
            }

            if ($data instanceof \JsonSerializable) {
                $value = $data->jsonSerialize();
            } elseif (method_exists($data, '__toString')) {
                $value = $data->__toString();
            } else {
                $encoded = $this->toJson($data, true);

                if ($encoded === false) {
                    $value = 'JSON_ERROR';
                } else {
                    $value = json_decode($encoded, true);
                }
            }

            return [Utils::getClass($data) => $value];
        }

        if (is_resource($data)) {
            return parent::normalize($data);
        }

        return $data;
    }

    /**
     * @return int
     */
    public function getMaxNormalizeItemCount(): int
    {
        return $this->maxNormalizeItemCount;
    }

    /**
     * Normalizes given exception with or without its own stack trace based on
     * `includeStacktraces` property.
     *
     * @param Exception|Throwable $e
     * @param int $depth
     * @return array
     */
    protected function normalizeException($e, $depth = 0): array
    {
        // TODO 2.0 only check for Throwable
        if (!$e instanceof Exception && !$e instanceof Throwable) {
            throw new \InvalidArgumentException('Exception/Throwable expected, got ' . gettype($e) . ' / ' .
                Utils::getClass($e));
        }

        $data = array(
            'class' => Utils::getClass($e),
            'message' => $e->getMessage(),
            'code' => (int)$e->getCode(),
            'file' => $e->getFile() . ':' . $e->getLine(),
        );

        if ($this->includeStacktraces) {
            $trace = $e->getTrace();
            foreach ($trace as $frame) {
                if (isset($frame['file'])) {
                    $data['trace'][] = $frame['file'] . ':' . $frame['line'] . ($this->appendNewline ? "\n" : '');
                }
            }
        }

        if ($previous = $e->getPrevious()) {
            $data['previous'] = $this->normalizeException($previous);
        }

        return $data;
    }

    /**
     * Return a JSON-encoded array of records.
     *
     * @param array $records
     * @return string
     */
    protected function formatBatchJson(array $records): string
    {
        return $this->toJson($this->normalize($records), true);
    }
}