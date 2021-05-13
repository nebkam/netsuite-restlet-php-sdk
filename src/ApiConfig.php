<?php

namespace Infostud\NetSuiteSdk;

use Infostud\NetSuiteSdk\Serializer\ApiSerializer;
use RuntimeException;

class ApiConfig
	{
	/**
	 * @var string
	 */
	private $account;
	/**
	 * @var string
	 */
	public $consumerKey;
	/**
	 * @var string
	 */
	public $consumerSecret;
	/**
	 * @var string
	 */
	public $accessTokenKey;
	/**
	 * @var string
	 */
	public $accessTokenSecret;
	/**
	 * @var RestletMap
	 */
	public $restletMap;

	/**
	 * @return string
	 */
	public function getAccount()
		{
		return $this->account;
		}

	/**
	 * @param string $account
	 * @return self
	 */
	public function setAccount($account)
		{
		$this->account = $account;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getRealm()
		{
		return $this->account;
		}

	/**
	 * @return string
	 */
	public function getRestletUrlFragment()
		{
		return str_replace('_', '-', strtolower($this->account));
		}

	/**
	 * @param string $path
	 * @param ApiSerializer $serializer
	 * @return self
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	public static function fromJsonFile($path, $serializer)
		{
		if (!file_exists($path)
			|| !is_readable($path))
			{
			throw new RuntimeException(
				sprintf('File at `%s` doesn\'t exist or isn\'t readable', $path)
			);
			}
		$contents = file_get_contents($path);

		/** @noinspection PhpIncompatibleReturnTypeInspection */
		return $serializer->deserialize($contents, __CLASS__);
		}
	}
