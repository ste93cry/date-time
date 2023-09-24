<?php

declare(strict_types=1);

namespace Brick\DateTime\Parser;

final class ParsePosition
{
    private $index;

    private $errorIndex = -1;

    public function __construct(int $index)
    {
        $this->index = $index;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function setIndex(int $index): void
    {
        $this->index = $index;
    }

    public function getErrorIndex(): int
    {
        return $this->errorIndex;
    }

    public function setErrorIndex(int $errorIndex): void
    {
        $this->errorIndex = $errorIndex;
    }
}
