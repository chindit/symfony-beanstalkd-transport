<?php
declare(strict_types=1);

use Symfony\Component\Messenger\Transport\TransportFactoryInterface;

class BeanstalkTransportFactory implements TransportFactoryInterface
{
	public function createTransport(string $dsn, array $options, \Symfony\Component\Messenger\Transport\Serialization\SerializerInterface $serializer): \Symfony\Component\Messenger\Transport\TransportInterface
	{
		// TODO: Implement createTransport() method.
	}

	public function supports(string $dsn, array $options): bool
	{
		return str_starts_with($dsn, 'beanstalk://');
	}
}
