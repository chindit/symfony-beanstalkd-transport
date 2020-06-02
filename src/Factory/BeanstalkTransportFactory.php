<?php
declare(strict_types=1);

use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class BeanstalkTransportFactory implements TransportFactoryInterface
{
	public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
	{
		return new BeanstalkTransport('127.0.0.1', '', $serializer);
	}

	public function supports(string $dsn, array $options): bool
	{
		return str_starts_with($dsn, 'beanstalk://');
	}
}
