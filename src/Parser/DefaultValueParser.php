<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

final class DefaultValueParser implements DateTimeParserV2
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var int
     */
    private $value;

    public function __construct(string $field, int $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function parse(DateTimeParseContext $context, string $text, int $position): int
    {
        if ($context->hasParsedField($this->field)) {
            $context->setParsedField($this->field, $this->value, $position, $position);
        }

        return $position;
    }
}
