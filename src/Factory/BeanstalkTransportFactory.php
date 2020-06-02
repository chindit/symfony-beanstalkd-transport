<?php
declare(strict_types=1);

namespace Chindit\Bundle\Factory;

use Chindit\Bundle\Exception\ConfigurationException;
use Chindit\Bundle\Transport\BeanstalkTransport;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class BeanstalkTransportFactory implements TransportFactoryInterface
{
	public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
	{
		$url = parse_url($dsn);
		$arguments = [];

		if (!isset($url['host'])) {
			throw new ConfigurationException('Host is required for Beanstalk connection');
		}

		unset($url['scheme']);

		if (isset($url['query'])) {
			parse_str($url['query'], $arguments);
		}

		if (isset($url['path'])) {
			$result = preg_replace('/[^A-Za-z0-9\-]/', '', $url['path']);
			if (is_string($result) && $result !== '') {
				$url['tube'] = $result;
			}
			unset($url['path']);
		}

		return new BeanstalkTransport(array_merge($arguments, $url), $serializer);
	}

	public function supports(string $dsn, array $options): bool
	{
		return str_starts_with($dsn, 'beanstalk://');
	}
}
