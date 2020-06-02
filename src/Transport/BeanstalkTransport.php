<?php
declare(strict_types=1);

namespace Chindit\Transport;

use Pheanstalk\JobId;
use Pheanstalk\Pheanstalk;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\TransportMessageIdStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class BeanstalkTransport implements TransportInterface
{
	private Pheanstalk $pheanstalk;
	private string $defaultPipe;
	private SerializerInterface $serializer;

	public function __construct(string $address, ?string $defaultPipe, SerializerInterface $serializer)
	{
		$this->pheanstalk = Pheanstalk::create($address);
		$this->defaultPipe = $defaultPipe ?? 'default';
		$this->serializer = $serializer;
	}

	public function get(): iterable
	{
		$job = $this->pheanstalk
			->useTube($this->defaultPipe)
			->reserveWithTimeout(0);

		if ($job === null) {
			return [];
		}

		try
		{
			$envelope = $this->serializer->decode(json_decode($job->getData(), true, 512, JSON_THROW_ON_ERROR));
		}
		catch (JsonException $e)
		{
			return [];
		}

		return [$envelope->with(new TransportMessageIdStamp($job->getId()))];
	}

	public function ack(Envelope $envelope): void
	{
		$stamp = $envelope->last(TransportMessageIdStamp::class);

		if (!$stamp instanceof TransportMessageIdStamp) {
			throw new LogicException('No TransportMessageIdStamp found on the Envelope');
		}

		$this->pheanstalk->useTube($this->defaultPipe)->release(new JobId($stamp->getId()));
	}

	public function reject(Envelope $envelope): void
	{
		$stamp = $envelope->last(TransportMessageIdStamp::class);
		if (!$stamp instanceof TransportMessageIdStamp) {
			throw new \LogicException('No TransportMessageIdStamp found on the Envelope.');
		}

		$this->pheanstalk->useTube($this->defaultPipe)->bury(new JobId($stamp->getId()));
	}

	public function send(Envelope $envelope): Envelope
	{

		$job = $this->pheanstalk
			->useTube($this->defaultPipe)
			->put(json_encode($this->serializer->encode($envelope), JSON_THROW_ON_ERROR))
		;

		return $envelope->with(new TransportMessageIdStamp($job->getId()));
	}

}
