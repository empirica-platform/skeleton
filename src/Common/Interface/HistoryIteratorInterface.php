<?php

namespace EmpiricaPlatform\Common\Interface;

use EmpiricaPlatform\Common\ValueObject\SymbolPair;

interface HistoryIteratorInterface extends \Traversable
{
    public function __construct(
        SymbolPair         $symbolPair,
        \DateInterval      $interval,
        \DateTimeInterface $start,
        \DateTimeInterface $end
    );
}
