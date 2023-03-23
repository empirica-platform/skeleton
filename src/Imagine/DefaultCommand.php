<?php

namespace EmpiricaPlatform\Imagine;

use EmpiricaPlatform\Common\ValueObject\OhlcDataFrame;
use EmpiricaPlatform\Common\ValueObject\SymbolPair;
use EmpiricaPlatform\DummyHistory\OhlcIterator;
use EmpiricaPlatform\Draw\HistoryData\Ohlc;
use EmpiricaPlatform\Draw\HistoryData\OhlcList;
use EmpiricaPlatform\Draw\DrawImage\DrawCanvas;
use EmpiricaPlatform\Draw\DrawImage\DrawAvgVolume;
use EmpiricaPlatform\Draw\DrawImage\DrawBgOhlcList;
use EmpiricaPlatform\Draw\DrawImage\DrawBorder;
use EmpiricaPlatform\Draw\DrawImage\DrawOhlcList;
use EmpiricaPlatform\Draw\DrawImage\DrawRSI;
use EmpiricaPlatform\Draw\DrawImage\DrawSingleValue;
use EmpiricaPlatform\Draw\DrawImage\DrawVolume;
use EmpiricaPlatform\Draw\MovingAverage\Sma;
use Nette\Utils\DateTime;
use Nette\Utils\Image;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $imagine = new \Imagine\Gd\Imagine();
        $size    = new \Imagine\Image\Box(40, 40);
        $mode    = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        //$mode    = \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

        return static::SUCCESS;
    }
}
