<?php

namespace Infostud\NetSuiteSdk\Exception;

use Exception;

class ApiLogicException extends Exception
	{
	/**
	 * @var string
	 */
	private $errorName;

	/**
	 * @param string $errorName
	 * @param string $errorMessage
	 */
	public function __construct($errorName, $errorMessage)
		{
		parent::__construct($errorMessage);

		$this->errorName = $errorName;
		}

	/**
	 * @return string
	 */
	public function getErrorName()
		{
		return $this->errorName;
		}
	}
