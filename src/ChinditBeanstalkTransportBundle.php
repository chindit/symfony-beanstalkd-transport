<?php

namespace Chindit\Bundle;

use Chindit\Bundle\Factory\BeanstalkTransportFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChinditBeanstalkTransportBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		if (!$container->has(BeanstalkTransportFactory::class)) {
			$container->register(BeanstalkTransportFactory::class);
		}

		$definition = $container->getDefinition(BeanstalkTransportFactory::class);
		$definition->addTag('messenger.transport_factory');
	}
}
