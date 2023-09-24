<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

use Brick\DateTime\Field\HourOfDay;
use Brick\DateTime\Field\MinuteOfHour;
use Brick\DateTime\Field\NanoOfSecond;
use Brick\DateTime\Field\SecondOfMinute;
use Brick\DateTime\LocalTime;
use Brick\DateTime\TemporalAccessor;
use Brick\DateTime\TimeZone;

final class Parsed implements TemporalAccessor
{
    /**
     * @var TimeZone
     */
    public $zone;

    /**
     * @var array<string, int>
     */
    public $fieldValues = [];

    /**
     * @var LocalTime|null
     */
    private $localTime;

    public function resolve(): TemporalAccessor
    {
        return $this;
    }

    public function query(\Closure $query)
    {
        // compat
        $a = new DateTimeParseResult();

        foreach ($this->fieldValues as $field => $value) {
            $a->addField($field, (string) $value);
        }

        return $query($a);
    }

    private function resolveFields(): void
    {
        $this->resolveTimeFields();
    }

    private function resolveTimeFields(): void
    {
        if (isset($this->fieldValues[NanoOfSecond::NAME])) {
            $nanoOfSecond = $this->fieldValues[NanoOfSecond::NAME];

            NanoOfSecond::check($nanoOfSecond);
        }

        if (isset($this->fieldValues[HourOfDay::NAME], $this->fieldValues[MinuteOfHour::NAME], $this->fieldValues[SecondOfMinute::NAME], $this->fieldValues[NanoOfSecond::NAME])) {
            $hourOfDay = $this->takeField(HourOfDay::NAME);
            $minuteOfHour = $this->takeField(MinuteOfHour::NAME);
            $secondOfMinute = $this->takeField(SecondOfMinute::NAME);
            $nanoOfSecond = $this->takeField(NanoOfSecond::NAME);

            $this->resolveTime($hourOfDay, $minuteOfHour, $secondOfMinute, $nanoOfSecond);
        }
    }

    private function resolveTime(int $hourOfDay, int $minuteOfHour, int $secondOfMinute, int $nanoOfSecond): void
    {
        $totalNanos = $hourOfDay * 3600000000000;
        $totalNanos += $minuteOfHour * 60000000000;
        $totalNanos += $secondOfMinute * 1000000000;
        $totalNanos += $nanoOfSecond;

        $nanoOfDay = fmod($totalNanos, 86400000000000);
    }

    private function takeField(string $name): int
    {
        $value = $this->fieldValues[$name];

        unset($this->fieldValues[$name]);

        return $value;
    }
}
