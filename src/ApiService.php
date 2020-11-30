<?php

namespace Infostud\NetSuiteSdk;

use Eher\OAuth\Consumer;
use Eher\OAuth\HmacSha1;
use Eher\OAuth\OAuthException;
use Eher\OAuth\Request;
use Eher\OAuth\SignatureMethod;
use Eher\OAuth\Token;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Infostud\NetSuiteSdk\Model\CustomerSearchResponse;

class ApiService
	{
	const RESTLET_CUSTOMER_SEARCH = 363;
	/**
	 * @var string
	 */
	private $account;
	/**
	 * @var string
	 */
	private $restletHost;
	/**
	 * @var Client
	 */
	private $client;
	/**
	 * @var Consumer
	 */
	private $consumer;
	/**
	 * @var Token
	 */
	private $accessToken;
	/**
	 * @var SignatureMethod
	 */
	private $signatureMethod;
	/**
	 * @var ApiSerializer
	 */
	private $serializer;

	/**
	 * @param string $account
	 * @param string $consumerKey
	 * @param string $consumerSecret
	 * @param string $accessTokenKey
	 * @param string $accessTokenSecret
	 */
	public function __construct($account, $consumerKey, $consumerSecret, $accessTokenKey, $accessTokenSecret)
		{
		$this->account         = $account;
		$this->restletHost     = $account . '.restlets.api.netsuite.com';
		$this->client          = new Client();
		$this->consumer        = new Consumer($consumerKey, $consumerSecret);
		$this->accessToken     = new Token($accessTokenKey, $accessTokenSecret);
		$this->signatureMethod = new HmacSha1();
		$this->serializer      = new ApiSerializer();
		}

	/**
	 * @param array $filters
	 * @return CustomerSearchResponse
	 * @throws OAuthException|GuzzleException
	 */
	public function customerSearch($filters)
		{
		$requestBody = [
			'filters' => $filters
		];
		$url = $this->getUrl(self::RESTLET_CUSTOMER_SEARCH, 1);

		$response = $this->client->request('POST', $url, [
			RequestOptions::HEADERS => $this->buildHeaders('POST', $url),
			RequestOptions::JSON    => $requestBody
		]);
		if ($response->getStatusCode() === 200)
			{
			$contents = (string)$response->getBody()->getContents();

			return $this->serializer->deserialize($contents, CustomerSearchResponse::class);
			}
		// TODO error
		}

	/**
	 * @param int $scriptId
	 * @param int $deploymentId
	 * @return string
	 */
	private function getUrl($scriptId, $deploymentId)
		{
		$query_data = [
			'script' => $scriptId,
			'deploy' => $deploymentId
		];

		return sprintf('https://%s.restlets.api.netsuite.com/app/site/hosting/restlet.nl?', $this->account)
			. http_build_query($query_data);
		}

	/**
	 * @param string $method
	 * @param string $url
	 * @return array
	 * @throws OAuthException
	 */
	private function buildHeaders($method, $url)
		{
		$request   = new Request($method, $url, [
			'oauth_nonce'            => md5(mt_rand()),
			'oauth_timestamp'        => idate('U'),
			'oauth_version'          => '1.0',
			'oauth_token'            => $this->accessToken->key,
			'oauth_consumer_key'     => $this->consumer->key,
			'oauth_signature_method' => $this->signatureMethod->get_name(),
		]);
		$signature = $request->build_signature($this->signatureMethod, $this->consumer, $this->accessToken);
		$request->set_parameter('oauth_signature', $signature);
		$request->set_parameter('realm', $this->account);

		return [
			'Authorization' => substr($request->to_header($this->account), 15),
			'Host'          => $this->restletHost
		];
		}
	}
