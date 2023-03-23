<?php

namespace EmpiricaPlatform\Common\ValueObject;

/**
 * @property-read \DateTimeInterface $time
 */
class OhlcDataFrame
{
    public function __construct(
        public readonly \DateTimeInterface $time,
        public readonly SymbolPair $symbolPair,
        public readonly float $openPrice,
        public readonly float $highPrice,
        public readonly float $lowPrice,
        public readonly float $closePrice,
        public readonly float $volume
    )
    {
    }
}
