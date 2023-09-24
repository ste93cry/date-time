<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

final class NumberParser implements DateTimeParserV2
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var int
     */
    private $minWidth;

    /**
     * @var int
     */
    private $maxWidth;

    public function __construct(string $field, int $minWidth, int $maxWidth)
    {
        $this->field = $field;
        $this->minWidth = $minWidth;
        $this->maxWidth = $maxWidth;
    }

    public function parse(DateTimeParseContext $context, string $text, int $position): int
    {
        $length = strlen($text);

        if ($position === $length) {
            return ~$position;
        }

        $effectiveMinWidth = 1;
        $minEndPosition = $position + $effectiveMinWidth;

        // If the minimum end position comes after the end of the input text,
        // it means that we certainly cannot parse the number successfully
        if ($minEndPosition > $length) {
            return ~$position;
        }

        $effectiveMaxWidth = 9;
        $total = 0;
        $index = $position;

        for ($pass = 0; $pass < 2; ++$pass) {
            $maxEndPosition = min($index + $effectiveMaxWidth, $length);

            while ($index < $maxEndPosition) {
                $char = $text[$index++];

                if (!ctype_digit($char)) {
                    --$index;

                    // If the current position is before the minimum required
                    // end position, it means that we didn't parse enough digits
                    if ($index < $minEndPosition) {
                        return ~$position;
                    }

                    break;
                }

                $total = $total * 10 + intval($char);
            }

            // subsequentwidth ...
            break;
        }

        return $context->setParsedField($this->field, $total, $position, $index);
    }
}
