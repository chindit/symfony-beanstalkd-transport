<?php

namespace Chindit\BeanstalkTransportBundle;

use Chindit\Factory\BeanstalkTransportFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChinditBeanstalkTransportBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);

		if (!$container->has(BeanstalkTransportFactory::class)) {
			return;
		}

		$definition = $container->getDefinition(BeanstalkTransportFactory::class);
		$definition->addTag('messenger.transport_factory');
	}
}
