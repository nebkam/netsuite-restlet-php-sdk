<?php

namespace Infostud\NetSuiteSdk\Exception;

use Eher\OAuth\OAuthException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ApiTransferException extends Exception implements ApiException
	{
	/**
	 * @var string|null
	 */
	private $responseBody;

	public function getResponseBody(): ?string
		{
		return $this->responseBody;
		}

	public function setResponseBody(?string $responseBody): self
		{
		$this->responseBody = $responseBody;

		return $this;
		}

	public static function fromSerializationException(ExceptionInterface $exception): self
		{
		return new self($exception->getMessage(), $exception->getCode(), $exception);
		}
	public static function fromStatusCode(int $statusCode, ?string $responseBody): self
		{
		return (new self(sprintf('Unexpected response status code: %d', $statusCode), $statusCode))
			->setResponseBody($responseBody);
		}
	public static function fromOAuthException(OAuthException $exception): self
		{
		return new self($exception->getMessage(), $exception->getCode(), $exception);
		}
	public static function fromGuzzleException(GuzzleException $exception): self
		{
		return new self($exception->getMessage(), $exception->getCode(), $exception);
		}
	}
