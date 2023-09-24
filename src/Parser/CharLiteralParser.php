<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

final class CharLiteralParser implements DateTimeParserV2
{
    /**
     * @var string
     */
    private $literal;

    public function __construct(string $literal)
    {
        if (strlen($literal) > 1) {
            throw new \InvalidArgumentException('The $literal argument is too long, expected it to be of 1 char.');
        }

        $this->literal = $literal;
    }

    public function parse(DateTimeParseContext $context, string $text, int $position): int
    {
        $length = strlen($text);

        if ($position === $length) {
            return ~$position;
        }

        if ($this->literal !== $text[$position]) {
            return ~$position;
        }

        return $position + 1;
    }
}
