<?php

namespace EmpiricaPlatform\Draw;

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
        error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING);

        $csvOhlc = OhlcList::create(0);
        $serializer = new Serializer([new PropertyNormalizer(), new DateTimeNormalizer()], [new JsonEncoder()]);

        while ($line = fgets(STDIN)) {
            /** @var OhlcDataFrame $frame */
            $frame = $serializer->deserialize($line, OhlcDataFrame::class, 'json');
            Ohlc::create(
                DateTime::from($frame->time),
                $frame->openPrice,
                $frame->highPrice,
                $frame->lowPrice,
                $frame->closePrice,
                $frame->volume,
                $csvOhlc
            );
        }

        $canvas =  DrawCanvas::createCanvas(1000, 600);
        $canvas->setFontPath('/Users/miha/PhpstormProjects/skeleton/src/Draw/font/Hack-Regular.ttf');
        $drawPrice = DrawOhlcList::create($csvOhlc, DrawBorder::create($canvas));
        DrawBgOhlcList::createBg($drawPrice)
            ->setProductName('BTCUSDT');
        DrawVolume::create(75, $drawPrice);
        $canvas->drawImage();

        return static::SUCCESS;
    }
}
