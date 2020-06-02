<?php

namespace Chindit;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Messenger\DependencyInjection\BeanstalkTransportPass;

class Kernel extends BaseKernel
{
	protected function build(ContainerBuilder $container)
	{
		$container->addCompilerPass(new BeanstalkTransportPass());
	}

	public function registerBundles()
	{
		// Nothing to do
	}

	public function registerContainerConfiguration(LoaderInterface $loader)
	{
		// Nothing to do
	}
}
