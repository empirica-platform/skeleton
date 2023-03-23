<?php

namespace EmpiricaPlatform\Common\ValueObject;

class SymbolPair implements \Stringable
{
    public function __construct(
        public readonly string $base,
        public readonly string $quote
    )
    {
    }

    public function __toString(): string
    {
        return $this->base . '/' . $this->quote;
    }
}
