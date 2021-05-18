<?php

namespace Infostud\NetSuiteSdk;

use Eher\OAuth\Consumer;
use Eher\OAuth\OAuthException;
use Eher\OAuth\Request;
use Eher\OAuth\SignatureMethod;
use Eher\OAuth\Token;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Infostud\NetSuiteSdk\Exception\ApiTransferException;

class ApiClient
	{
	/**
	 * @var ApiConfig
	 */
	private $config;
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
	 * @param ApiConfig $config
	 */
	public function __construct($config)
		{
		$this->config          = $config;
		$this->client          = new Client();
		$this->signatureMethod = $this->config->getSignatureMethodImplementation();
		$this->consumer        = new Consumer(
			$this->config->consumerKey,
			$this->config->consumerSecret
		);
		$this->accessToken     = new Token(
			$this->config->accessTokenKey,
			$this->config->accessTokenSecret
		);
		}

	/**
	 * @param string $url
	 * @param array $requestBody
	 * @return string
	 * @throws ApiTransferException
	 */
	public function post($url, array $requestBody)
		{
		try
			{
			$clientResponse = $this->client->request('POST', $url, [
				RequestOptions::HEADERS => $this->buildHeaders('POST', $url),
				RequestOptions::JSON    => $requestBody
			]);
			}
		catch (GuzzleException $exception)
			{
			throw ApiTransferException::fromGuzzleException($exception);
			}

		if ($clientResponse->getStatusCode() !== 200)
			{
			throw ApiTransferException::fromStatusCode($clientResponse->getStatusCode());
			}

		return $clientResponse->getBody()->getContents();
		}

	/**
	 * @param string $url
	 * @return string
	 * @throws ApiTransferException
	 */
	public function get($url)
		{
		try
			{
			$clientResponse = $this->client->request('GET', $url, [
				RequestOptions::HEADERS => $this->buildHeaders('GET', $url, 'application/pdf')
			]);
			}
		catch (GuzzleException $exception)
			{
			throw ApiTransferException::fromGuzzleException($exception);
			}

		if ($clientResponse->getStatusCode() !== 200)
			{
			throw ApiTransferException::fromStatusCode($clientResponse->getStatusCode());
			}

		return $clientResponse->getBody()->getContents();
		}

	/**
	 * @param string $url
	 * @return string
	 * @throws ApiTransferException
	 */
	public function delete($url)
		{
		try
			{
			$clientResponse = $this->client->request('DELETE', $url, [
				RequestOptions::HEADERS => $this->buildHeaders('DELETE', $url)
			]);
			}
		catch (GuzzleException $exception)
			{
			throw ApiTransferException::fromGuzzleException($exception);
			}

		if ($clientResponse->getStatusCode() !== 200)
			{
			throw ApiTransferException::fromStatusCode($clientResponse->getStatusCode());
			}

		return $clientResponse->getBody()->getContents();
		}

	/**
	 * @param string $method
	 * @param string $url
	 * @param string $contentType
	 *
	 * @return array
	 * @throws ApiTransferException
	 */
	private function buildHeaders($method, $url, $contentType = 'application/json')
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
		$request->set_parameter('realm', $this->config->getRealm());

		try
			{
			return [
				'Authorization' => substr($request->to_header($this->config->getRealm()), 15),
				'Host'          => $this->config->getRestletHost(),
				'Content-Type'  => $contentType
			];
			}
		catch (OAuthException $exception)
			{
			throw ApiTransferException::fromOAuthException($exception);
			}
		}
	}
