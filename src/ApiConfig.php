<?php

namespace Infostud\NetSuiteSdk;

use Eher\OAuth\HmacSha1;
use Eher\OAuth\SignatureMethod;
use Infostud\NetSuiteSdk\Model\Oauth\HmacSha256;
use Infostud\NetSuiteSdk\Serializer\ApiSerializer;
use RuntimeException;

class ApiConfig
	{
	const SIGNATURE_METHOD_HMAC_SHA1 = 'HMAC-SHA1';
	const SIGNATURE_METHOD_HMAC_SHA256 = 'HMAC-SHA256';
	const ALLOWED_SIGNATURE_METHODS = [
		self::SIGNATURE_METHOD_HMAC_SHA1,
		self::SIGNATURE_METHOD_HMAC_SHA256
	];

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
	 * @var string
	 */
	public $signatureMethod;
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
	 * @return SignatureMethod
	 */
	public function getSignatureMethodImplementation()
		{
		switch ($this->signatureMethod) {
			case self::SIGNATURE_METHOD_HMAC_SHA1:
				return new HmacSha1();

			case self::SIGNATURE_METHOD_HMAC_SHA256:
				return new HmacSha256();

			default;
				throw new RuntimeException(sprintf(
					'Invalid signature method: %s. Allowed signature methods are: %s',
					$this->signatureMethod,
					implode(', ', self::ALLOWED_SIGNATURE_METHODS)
				));
			}
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
