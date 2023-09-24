<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

interface DateTimeParserV2
{
    /**
     * Parses the given text and extracts from it the date-time information. The
     * context holds the information to use during the parse and it is also used
     * to store the parsed date-time information.
     *
     * @return int The new parse position, where negative means an error with the
     *             error position encoded using the complement ~ operator
     */
    public function parse(DateTimeParseContext $context, string $text, int $position): int;
}
