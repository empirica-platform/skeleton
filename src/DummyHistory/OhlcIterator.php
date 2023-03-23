<?php

namespace EmpiricaPlatform\DummyHistory;

use EmpiricaPlatform\Common\Interface\HistoryIteratorInterface;
use EmpiricaPlatform\Common\ValueObject\OhlcDataFrame;
use EmpiricaPlatform\Common\ValueObject\SymbolPair;
use NXP\MathExecutor;

class OhlcIterator implements \IteratorAggregate, HistoryIteratorInterface
{
    protected string $openExpr;
    protected string $highExpr;
    protected string $lowExpr;
    protected string $closeExpr;
    protected string $volumeExpr;
    protected MathExecutor $executor;

    public function __construct(
        protected SymbolPair         $symbolPair,
        protected \DateInterval      $interval,
        protected \DateTimeInterface $start,
        protected \DateTimeInterface $end
    )
    {
        $this->configure();
    }

    public function configure(
        string $openExpr = 'sin(pi * (n * .2 - .2)) + 40',
        string $highExpr = 'sin(pi * (n * .2 - .2)) + 41',
        string $lowExpr = 'sin(pi * (n * .2)) + 39',
        string $closeExpr = 'sin(pi * (n * .2)) + 40',
        string $volumeExpr = 'sin(pi * 2 * (n * .2 - 1.2)) * 50 + 60',
        MathExecutor $executor = new MathExecutor()
    ): void
    {
        $this->openExpr = $openExpr;
        $this->highExpr = $highExpr;
        $this->lowExpr = $lowExpr;
        $this->closeExpr = $closeExpr;
        $this->volumeExpr = $volumeExpr;
        $this->executor = $executor;
    }

    public function getIterator(): \Traversable
    {
        foreach (new \DatePeriod($this->start, $this->interval, $this->end) as $n => $date) {
            $this->executor->setVar('n', $n);
            yield new OhlcDataFrame(
                $date,
                $this->symbolPair,
                $this->executor->execute($this->openExpr),
                $this->executor->execute($this->highExpr),
                $this->executor->execute($this->lowExpr),
                $this->executor->execute($this->closeExpr),
                $this->executor->execute($this->volumeExpr)
            );
        }
    }
}
