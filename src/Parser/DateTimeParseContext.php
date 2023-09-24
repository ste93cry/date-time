<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

use Brick\DateTime\TemporalAccessor;

/**
 * This class represents the current state of the parse of a date and time. It
 * is a mutable context intended to be used exclusively from an implementation
 * of the {@see DateTimeParser} interface.
 */
final class DateTimeParseContext
{
    /**
     * @var list<Parsed>
     */
    private $parsed = [];

    public function __construct()
    {
        $this->parsed[] = new Parsed();
    }

    public function hasParsedField(string $field): bool
    {
        return isset($this->parsed[$field]);
    }

    public function getParsedField(string $field): int
    {
        return $this->getCurrentParsed()->fieldValues[$field];
    }

    public function setParsedField(string $field, int $value, int $errorPosition, int $successPosition): int
    {
        $currentParsed = $this->getCurrentParsed();
        $oldValue = $currentParsed->fieldValues[$field] ?? null;

        $currentParsed->fieldValues[$field] = $value;

        if ($oldValue !== null && $oldValue !== $value) {
            return ~$errorPosition;
        }

        return $successPosition;
    }

    public function toResolved(): TemporalAccessor
    {
        return $this->getCurrentParsed()->resolve();
    }

    private function getCurrentParsed(): Parsed
    {
        return $this->parsed[count($this->parsed) - 1];
    }
}
