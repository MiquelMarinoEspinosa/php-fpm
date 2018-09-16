<?php

namespace Php\Fpm;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\RouteCollectionBuilder;

class AppKernel extends Kernel
{
    use MicroKernelTrait;

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

    public function getName()
    {
        return '';
    }

    public function getLogDir()
    {
        return $this->rootDir . '/var/logs';
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $confDir = $this->getProjectDir().'/config/' . $this->getEnvironment();
        $routes->import($confDir . '/routes.yml');
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $environment = $this->getEnvironment();
        $loader->load($this->getRootDir().'/config/' . $environment . '/config.yml');
    }
}
