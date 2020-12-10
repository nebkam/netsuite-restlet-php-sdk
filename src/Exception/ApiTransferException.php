<?php

namespace Infostud\NetSuiteSdk\Exception;

use Eher\OAuth\OAuthException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class ApiTransferException extends Exception
	{
	public static function fromStatusCode($statusCode)
		{
		return new self(sprintf('Unexpected response status code: %d', $statusCode), $statusCode);
		}
	public static function fromOAuthException(OAuthException $exception)
		{
		return new self($exception->getMessage(), $exception->getCode(), $exception);
		}
	public static function fromGuzzleException(GuzzleException $exception)
		{
		return new self($exception->getMessage(), $exception->getCode(), $exception);
		}
	}
