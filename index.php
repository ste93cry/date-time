<?php

declare(strict_types=1);

use Brick\DateTime\Field\DayOfMonth;
use Brick\DateTime\Field\HourOfDay;
use Brick\DateTime\Field\MinuteOfHour;
use Brick\DateTime\Field\MonthOfYear;
use Brick\DateTime\Field\NanoOfSecond;
use Brick\DateTime\Field\SecondOfMinute;
use Brick\DateTime\Field\Year;
use Brick\DateTime\LocalDateTime;
use Brick\DateTime\Parser\DateTimeParserBuilder;
use Brick\DateTime\Parser\IsoParsers;
use Brick\DateTime\Parser\PatternParserBuilder;

require_once __DIR__ . '/vendor/autoload.php';

$parser = (new DateTimeParserBuilder())
    ->appendValue(Year::NAME, 4, 10)
    ->appendLiteral('-')
    ->appendValue(MonthOfYear::NAME, 2, 2)
    ->appendLiteral('-')
    ->appendValue(DayOfMonth::NAME, 2, 2)
    ->appendLiteral(' ')
    ->appendValue(HourOfDay::NAME, 2, 2)
    ->appendLiteral(':')
    ->appendValue(MinuteOfHour::NAME, 2, 2)
    ->appendLiteral(':')
    ->appendValue(SecondOfMinute::NAME, 2, 2)
    ->parseDefaulting(NanoOfSecond::NAME, 0)
    ->toParser();

$a = $parser->parse('2021-07-20 22:24:02', Closure::fromCallable([LocalDateTime::class, 'from']));

$patternParser = (new PatternParserBuilder())
    ->append(IsoParsers::localDate())
    ->appendLiteral(' ')
    ->appendCapturePattern(HourOfDay::PATTERN, HourOfDay::NAME)
    ->appendLiteral(':')
    ->appendCapturePattern(MinuteOfHour::PATTERN, MinuteOfHour::NAME)
    ->appendLiteral(':')
    ->appendCapturePattern(SecondOfMinute::PATTERN, SecondOfMinute::NAME)
    ->toParser();

$c = $patternParser->parse('2021-07-20 22:24:02');
$d = 1;
