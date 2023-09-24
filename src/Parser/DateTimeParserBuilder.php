<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

final class DateTimeParserBuilder
{
    /**
     * @var self
     */
    private $active;

    /**
     * @var list<DateTimeParserV2>
     */
    private $parsers = [];

    /**
     * @var int
     */
    private $valueParserIndex = -1;

    public function __construct()
    {
        $this->active = $this;
    }

    /**
     * @return $this
     */
    public function parseDefaulting(string $field, int $value): self
    {
        $this->appendInternal(new DefaultValueParser($field, $value));

        return $this;
    }

    /**
     * @return $this
     */
    public function appendValue(string $field, int $minWidth, int $maxWidth): self
    {
        if ($minWidth < 1 || $minWidth > 19) {
            throw new \InvalidArgumentException();
        }

        if ($maxWidth < 1 || $maxWidth > 19) {
            throw new \InvalidArgumentException();
        }

        if ($maxWidth < $minWidth) {
            throw new \InvalidArgumentException();
        }

        $parser = new NumberParser($field, $minWidth, $maxWidth);

        $this->appendNumberParserValue($parser);

        return $this;
    }

    /**
     * @return $this
     */
    public function appendLiteral(string $literal): self
    {
        $this->appendInternal(new CharLiteralParser($literal));

        return $this;
    }

    /**
     * @return $this
     */
    public function appendInstant(): self
    {
        $this->appendInternal(new InstantParser(-2));

        return $this;
    }

    public function toParser(): Parser
    {
        $parser = new CompositeParser($this->parsers);

        return new Parser($parser);
    }

    private function appendNumberParserValue(NumberParser $parser): void
    {
        if ($this->active->valueParserIndex >= 0) {

        } else {
            $this->active->valueParserIndex = $this->appendInternal($parser);
        }
    }

    private function appendInternal(DateTimeParserV2 $parser): int
    {
        $this->active->parsers[] = $parser;
        $this->active->valueParserIndex = -1;

        return count($this->active->parsers) - 1;
    }
}
