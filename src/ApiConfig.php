<?php

namespace Infostud\NetSuiteSdk;

use Eher\OAuth\HmacSha1;
use Eher\OAuth\SignatureMethod;
use Infostud\NetSuiteSdk\Model\Oauth\HmacSha256;
use RuntimeException;

class ApiConfig
	{
	private const SIGNATURE_METHOD_HMAC_SHA1 = 'HMAC-SHA1';
	private const SIGNATURE_METHOD_HMAC_SHA256 = 'HMAC-SHA256';
	private const ALLOWED_SIGNATURE_METHODS = [self::SIGNATURE_METHOD_HMAC_SHA1, self::SIGNATURE_METHOD_HMAC_SHA256];

	/**
	 * @var string
	 */
	private $accountId;
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
	public function getAccountId(): string
		{
		return $this->accountId;
		}

	/**
	 * @param string $accountId
	 * @return ApiConfig
	 */
	public function setAccountId(string $accountId): self
		{
		$this->accountId = $accountId;

		return $this;
		}

	public function getRealm(): string
		{
		return $this->accountId;
		}

	public function getRestletUrlFragment(): string
		{
		return str_replace('_', '-', strtolower($this->accountId));
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
	 * @return SignatureMethod
	 * @throws RuntimeException
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
