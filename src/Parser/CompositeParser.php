<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

final class CompositeParser implements DateTimeParserV2
{
    /**
     * @var list<DateTimeParserV2>
     */
    private $parsers;

    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }

    public function parse(DateTimeParseContext $context, string $text, int $position): int
    {
        foreach ($this->parsers as $parser) {
            $position = $parser->parse($context, $text, $position);

            if ($position < 0) {
                break;
            }
        }

        return $position;
    }
}
