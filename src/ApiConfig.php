<?php

namespace Infostud\NetSuiteSdk;

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
	 * @var string
	 */
	public $signatureMethod;

	/**
	 * @return string
	 */
	public function getAccount(): string
		{
		return $this->account;
		}

	/**
	 * @param string $account
	 * @return ApiConfig
	 */
	public function setAccount(string $account): self
		{
		$this->account = $account;

		return $this;
		}

	public function getRealm(): string
		{
		return $this->account;
		}

	public function getRestletUrlFragment(): string
		{
		return str_replace('_', '-', strtolower($this->account));
		}

	/**
	 * @param Restlet $restlet
	 * @param array $additionalQueryParams
	 * @return string
	 */
	public function getRestletUrl(Restlet $restlet, $additionalQueryParams = []): string
		{
		$queryParams = array_merge([
			'script' => $restlet->script,
			'deploy' => $restlet->deploy
		], $additionalQueryParams);

		return sprintf('https://%s.restlets.api.netsuite.com/app/site/hosting/restlet.nl?', $this->getRestletUrlFragment())
			. http_build_query($queryParams);
		}

	public function getRestletHost(): string
		{
		return sprintf('%s.restlets.api.netsuite.com', $this->getRestletUrlFragment());
		}

	/**
	 * @throws Exception\ApiTransferException
	 */
	public static function fromJsonFile(string $path, ApiSerializer $serializer): self
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
