<?php

namespace Php\Cli;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    const TEST = 'test';
    const DEV = 'dev';

    public function registerBundles()
    {
        $bundles = [
            new FrameworkBundle(),
            new MonologBundle()
        ];

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__ . '/..';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $environment = $this->getEnvironment();
        if (self::TEST === $environment) {
            $environment = getenv('APP_ENV') ?: self::DEV;
        }

        $loader->load($this->getRootDir().'/config/' . $environment . '/config.yml');
    }

    public function getName()
    {
        return '';
    }

    public function getLogDir()
    {
        return $this->rootDir . '/var/logs';
    }
}
