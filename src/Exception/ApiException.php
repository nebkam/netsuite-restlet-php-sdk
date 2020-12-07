<?php

namespace Infostud\NetSuiteSdk\Exception;

use Eher\OAuth\OAuthException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class ApiException extends Exception
	{
	public static function fromStatusCode(int $statusCode): self
		{
		return new self(sprintf('Unexpected response status code: %d', $statusCode), $statusCode);
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
