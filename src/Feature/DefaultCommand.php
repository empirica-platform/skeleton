<?php

namespace EmpiricaPlatform\Feature;

use EmpiricaPlatform\Common\ValueObject\OhlcDataFrame;
use EmpiricaPlatform\Common\ValueObject\SymbolPair;
use EmpiricaPlatform\Draw\HistoryData\Ohlc;
use EmpiricaPlatform\DummyHistory\OhlcIterator;
use Nette\Utils\DateTime;
use NXP\MathExecutor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $executor = new MathExecutor();
        $serializer = new Serializer([new PropertyNormalizer(), new DateTimeNormalizer()], [new JsonEncoder()]);
        while ($line = fgets(STDIN)) {
            /** @var OhlcDataFrame $frame */
            $frame = $serializer->deserialize($line, OhlcDataFrame::class, 'json');
        }

        return static::SUCCESS;
    }
}
