<?php

namespace EmpiricaPlatform\Common;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

class BaseCommand extends Command
{
    protected ?ContainerBuilder $container;
    protected bool $running = false;

    protected function configure()
    {
        $this
            ->setName($_SERVER['argv'][0])
        ;
    }

    public function run(InputInterface $input = null, OutputInterface $output = null): int
    {
        if ($this->running) {
            return parent::run($input, $output);
        }

        $parameters = new ParameterBag([
            'empirica.project_dir' => $this->getProjectDir(),
        ]);
        $this->container = new ContainerBuilder($parameters);
        $this->container->addCompilerPass(new RegisterListenersPass(), PassConfig::TYPE_BEFORE_REMOVING);
        $loader = new YamlFileLoader($this->container, new FileLocator());
        $loader->load($this->getProjectDir() . '/config/common.yaml');
        $loader->load($this->getProjectDir() . '/config/history.yaml');
        $this->container->compile();

        $application = new Application();
        $application->add($this);
        $application->setDefaultCommand($this->getName(), true);

        $this->running = true;
        try {
            $ret = $application->run($input, $output);
        } finally {
            $this->running = false;
        }

        return $ret ?? static::FAILURE;
    }

    public function getProjectDir(): string
    {
        if (!isset($this->projectDir)) {
            $r = new \ReflectionObject($this);
            if (!is_file($dir = $r->getFileName())) {
                throw new \LogicException('Cannot auto-detect project dir.');
            }
            $dir = $rootDir = \dirname($dir);
            while (!is_file($dir.'/composer.lock')) {
                if ($dir === \dirname($dir)) {
                    return $this->projectDir = $rootDir;
                }
                $dir = \dirname($dir);
            }
            $this->projectDir = $dir;
        }

        return $this->projectDir;
    }
}
