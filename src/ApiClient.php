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
	private const DEFAULT_CONTENT_TYPE = 'application/json';

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

	public function __construct(ApiConfig $config)
		{
		$this->config = $config;
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
	public function post(string $url, array $requestBody): string
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

		return (string) $clientResponse->getBody();
		}

	/**
	 * @param string $url
	 * @param string|null $contentType
	 * @return string
	 * @throws ApiTransferException
	 */
	public function get(string $url, ?string $contentType = self::DEFAULT_CONTENT_TYPE): string
		{
		try
			{
			$clientResponse = $this->client->request('GET', $url, [
				RequestOptions::HEADERS => $this->buildHeaders('GET', $url, $contentType),
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

		return (string) $clientResponse->getBody();
		}

	/**
	 * @param string $url
	 * @return string
	 * @throws ApiTransferException
	 */
	public function delete(string $url): string
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

		return (string) $clientResponse->getBody();
		}

	/**
	 * @param string $method
	 * @param string $url
	 * @param string $contentType
	 * @return array
	 * @throws ApiTransferException
	 */
	private function buildHeaders(string $method, string $url, string $contentType = self::DEFAULT_CONTENT_TYPE): array
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
