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
use LogicException;
use RuntimeException;

class ApiService
	{
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
	 * @var int
	 */
	private $savedSearchCustomersId;

	/**
	 * @param string $configPath
	 */
	public function __construct($configPath)
		{
		$config = $this->readJsonConfig($configPath);

		$this->account                = $config['account'];
		$this->restletHost            = $config['account'] . '.restlets.api.netsuite.com';
		$this->client                 = new Client();
		$this->consumer               = new Consumer(
			$config['consumerKey'], $config['consumerSecret']
		);
		$this->accessToken            = new Token(
			$config['accessTokenKey'], $config['accessTokenSecret']
		);
		$this->signatureMethod        = new HmacSha1();
		$this->serializer             = new ApiSerializer();
		$this->savedSearchCustomersId = $config['restletIds']['savedSearchCustomers'];
		}

	/**
	 * @param string $vatIdentifier
	 * @return Model\Customer|null
	 */
	public function findCustomerByVatIdentifier($vatIdentifier)
		{
		$filters = [[
			'name'     => 'custentity_pib',
			'operator' => 'is',
			'values'   => [$vatIdentifier]
		]];
		try
			{
			$results = $this->customerSearch($filters);
			if (!empty($results->getCustomers()))
				{
				return $results->getCustomers()[0];
				}
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $e)
			{
			}

		return null;
		}

	/**
	 * @param array $filters
	 * @return CustomerSearchResponse
	 * @throws OAuthException|GuzzleException
	 */
	private function customerSearch($filters)
		{
		$requestBody = [
			'filters' => $filters
		];
		$url         = $this->getUrl($this->savedSearchCustomersId, 1);

		$response = $this->client->request('POST', $url, [
			RequestOptions::HEADERS => $this->buildHeaders('POST', $url),
			RequestOptions::JSON    => $requestBody
		]);

		if ($response->getStatusCode() === 200)
			{
			$contents = (string)$response->getBody()->getContents();

			return $this->serializer->deserialize($contents, CustomerSearchResponse::class);
			}

		throw new LogicException(
			sprintf('Unexpected response status code: %d', $response->getStatusCode())
		);
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

	/**
	 * @param string $path
	 * @throws RuntimeException
	 * @return array
	 */
	private function readJsonConfig($path)
		{
		if (!file_exists($path)
			|| !is_readable($path))
			{
			throw new RuntimeException(
				sprintf('File at `%s` doesn\'t exist or isn\'t readable', $path)
			);
			}

		$config = json_decode(file_get_contents($path), true);
		if (!$config)
			{
			throw new RuntimeException(
				sprintf('Malformed JSON, see sample.config.json for reference')
			);
			}

		return $config;
		}
	}
