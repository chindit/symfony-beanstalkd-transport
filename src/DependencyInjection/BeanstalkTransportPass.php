<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Messenger\DependencyInjection;

use Chindit\Factory\BeanstalkTransportFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BeanstalkTransportPass implements CompilerPassInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function process(ContainerBuilder $container)
	{
		if (!$container->has(BeanstalkTransportFactory::class)) {
			return;
		}

		$definition = $container->getDefinition(BeanstalkTransportFactory::class);
		$definition->addTag('messenger.transport_factory');
	}
}
