<?php

namespace EmpiricaPlatform\Common\ValueObject;

class FeatureDataFrame
{
    public function __construct(
        public readonly string $label,
        public readonly mixed $data,
    )
    {
    }
}
