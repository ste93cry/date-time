<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

final class InstantParser implements DateTimeParserV2
{
    /**
     * @var int
     */
    private $fractionalDigits;

    public function __construct(int $fractionalDigits)
    {
        $this->fractionalDigits = $fractionalDigits;
    }

    public function parse(DateTimeParseContext $context, string $text, int $position): int
    {

    }
}
