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
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SavedSearch\CustomerSearchResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Department;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetDepartmentsResponse;
use LogicException;
use RuntimeException;

class ApiService
	{
	const REQUEST_METHOD = 'POST';
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
	 * @var int
	 */
	private $suiteQLId;

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
		$this->suiteQLId              = $config['restletIds']['suiteQL'];
		}

	/**
	 * @param string $pib
	 * @return Customer|null
	 */
	public function findCustomerByPib($pib)
		{
		$filters = [[
			'name'     => 'custentity_pib',
			'operator' => 'is',
			'values'   => [$pib]
		]];
		try
			{
			$results = $this->executeSavedSearchCustomers($filters);
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
	 * @param string $pib
	 * @return Customer|null
	 */
	public function findCustomerByPibFragment($pib)
		{
		$filters = [[
			'name'     => 'custentity_pib',
			'operator' => 'contains',
			'values'   => [$pib]
		]];
		try
			{
			$results = $this->executeSavedSearchCustomers($filters);
			if (!empty($results->getCustomers()))
				{
				return $results->getCustomers()[0];
				}
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $exception)
			{
			}

		return null;
		}

	/**
	 * Find a company by MBR or an individual by JMBG
	 *
	 * @param string $registryIdentifier
	 * @return Customer|null
	 */
	public function findCustomerByRegistryIdentifier($registryIdentifier)
		{
		$filters = [[
			'name'     => 'custentity_matbrpred',
			'operator' => 'is',
			'values'   => [$registryIdentifier]
		]];
		try
			{
			$results = $this->executeSavedSearchCustomers($filters);
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
	 * @return Department[]
	 */
	public function getDepartments()
		{
		try
			{
			$results = $this->executeSuiteQuery(
				'select parent, id , name from department'
			);
			if (!empty($results->getRows()))
				{
				return $results->getRows();
				}
			}
		catch (OAuthException $exception)
			{
			}
		catch (GuzzleException $exception)
			{
			}

		return [];
		}

	/**
	 * @param array $filters
	 * @return CustomerSearchResponse
	 * @throws OAuthException|GuzzleException
	 */
	private function executeSavedSearchCustomers($filters)
		{
		$requestBody = [
			'filters' => $filters
		];
		$url         = $this->getUrl($this->savedSearchCustomersId, 1);

		$response = $this->client->request(self::REQUEST_METHOD, $url, [
			RequestOptions::HEADERS => $this->buildHeaders($url),
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
	 * @param string $from
	 * @param string $where
	 * @param array $params
	 * @return GetDepartmentsResponse
	 * @throws GuzzleException
	 * @throws OAuthException
	 */
	private function executeSuiteQuery($from, $where = ' ', $params = [])
		{
		$requestBody = [
			'sql_from'  => $from,
			'sql_where' => $where,
			'params'    => $params
		];
		$url         = $this->getUrl($this->suiteQLId, 1);
		$response = $this->client->request(self::REQUEST_METHOD, $url, [
			RequestOptions::HEADERS => $this->buildHeaders($url),
			RequestOptions::JSON    => $requestBody
		]);

		if ($response->getStatusCode() === 200)
			{
			$contents = (string)$response->getBody()->getContents();

			return $this->serializer->deserialize($contents, GetDepartmentsResponse::class);
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
	 * @param string $url
	 * @return array
	 * @throws OAuthException
	 */
	private function buildHeaders($url)
		{
		$request   = new Request(self::REQUEST_METHOD, $url, [
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
	 * @return array
	 * @throws RuntimeException
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
			throw new RuntimeException(sprintf(
				'Malformed JSON, see %s for reference',
				dirname(__DIR__) . '/sample.config.json'
			));
			}

		return $config;
		}
	}
