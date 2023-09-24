<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

use Brick\DateTime\TemporalAccessor;

final class Parser
{
    /**
     * @var CompositeParser
     */
    private $parser;

    public function __construct(CompositeParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @psalm-template T
     *
     * @psalm-param \Closure(TemporalAccessor): T $query
     *
     * @psalm-return T
     */
    public function parse(string $text, \Closure $query)
    {
        return $this->parseResolved($text)->query($query);
    }

    private function parseResolved(string $text): TemporalAccessor
    {
        $position = new ParsePosition(0);
        $context = $this->parseUnresolved($text, $position);

        return $context->toResolved();
    }

    private function parseUnresolved(string $text, ParsePosition $position): ?DateTimeParseContext
    {
        $context = new DateTimeParseContext();
        $index = $this->parser->parse($context, $text, $position->getIndex());

        if ($index < 0) {
            $position->setErrorIndex(~$index);

            return null;
        }

        $position->setIndex($index);

        return $context;
    }
}
