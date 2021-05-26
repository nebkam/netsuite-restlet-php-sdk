<?php

namespace Infostud\NetSuiteSdk\Exception;

use Exception;

class ApiLogicException extends Exception implements ApiException
	{
	/**
	 * @var string
	 */
	private $errorName;

	public function __construct(string $errorName, string $errorMessage)
		{
		parent::__construct($errorMessage);

		$this->errorName = $errorName;
		}

	/**
	 * @return string
	 */
	public function getErrorName(): string
		{
		return $this->errorName;
		}
	}
