<?php

namespace Chindit\DependencyInjection\Compiler;

use Chindit\Factory\BeanstalkTransportFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BeanstalkTransportCompilerPass implements CompilerPassInterface
{
	public function process(ContainerBuilder $container)
	{
		if (!$container->has(BeanstalkTransportFactory::class)) {
			return;
		}

		$definition = $container->getDefinition(BeanstalkTransportFactory::class);
		$definition->addTag('messenger.transport_factory');
	}
}
