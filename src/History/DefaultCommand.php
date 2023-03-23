<?php

namespace EmpiricaPlatform\History;

use Composer\InstalledVersions;
use EmpiricaPlatform\Common\ValueObject\OhlcDataFrame;
use EmpiricaPlatform\Common\ValueObject\SymbolPair;
use EmpiricaPlatform\DummyHistory\OhlcIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultCommand extends Command
{
    protected function configure(): void
    {
        $projectDir = Path::canonicalize(InstalledVersions::getRootPackage()['install_path']);
        $this
            ->addOption(
                'config-file', 'f',
                InputArgument::OPTIONAL,
                'Config yaml file',
                $projectDir . '/config/history.yaml'
            )
            ->addOption(
                'var-dir', 'd',
                InputArgument::OPTIONAL,
                'Output directory',
                $projectDir . '/var/history'
            )
            ->setHelp('Trading history data for backtesting');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pair = new SymbolPair('BTC', 'USDT');
        $interval = new \DateInterval('P1D');
        $start = new \DateTimeImmutable('2023-01-05');
        $end = new \DateTimeImmutable('2023-12-06');
        $frames = new OhlcIterator($pair, $interval, $start, $end);
        $serializer = new Serializer([new PropertyNormalizer(), new DateTimeNormalizer()], [new JsonEncoder()]);
        /** @var OhlcDataFrame $frame */
        foreach ($frames as $frame) {
            $output->writeln($serializer->serialize($frame, 'json'));
        }

        return static::SUCCESS;
    }
}
