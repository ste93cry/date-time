<?php

declare(strict_types=1);

namespace Brick\DateTime;

interface TemporalAccessor
{
    /**
     * @psalm-template T
     *
     * @param \Closure(TemporalAccessor): T $query
     *
     * @psalm-return T
     */
    public function query(\Closure $query);
}
