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
use Infostud\NetSuiteSdk\Exception\ApiException;
use Infostud\NetSuiteSdk\Model\CreateCustomerResponse;
use Infostud\NetSuiteSdk\Model\CustomerForm;
use Infostud\NetSuiteSdk\Model\DeleteCustomerResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetLocationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetSubsidiariesResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\SavedSearchCustomersResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Department;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetDepartmentsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Location;
use Infostud\NetSuiteSdk\Model\SuiteQL\Subsidiary;
use Infostud\NetSuiteSdk\Model\SuiteQL\SuiteQLResponse;
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
	 * @var int
	 */
	private $suiteQLId;
	/**
	 * @var int
	 */
	private $createDeleteCustomerId;

	/**
	 * @param string $configPath
	 */
	public function __construct(string $configPath)
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
		$this->createDeleteCustomerId = $config['restletIds']['createDeleteCustomer'];
		}

	/**
	 * @param CustomerForm $customerForm
	 * @return int|null
	 * @throws ApiException
	 */
	public function createCustomer(CustomerForm $customerForm): ?int
		{
		$url         = $this->getRestletUrl($this->createDeleteCustomerId, 3);
		$requestBody = $this->serializer->normalize($customerForm);
		$contents    = $this->executePostRequest($url, $requestBody);
		/** @var CreateCustomerResponse $apiResponse */
		$apiResponse = $this->serializer->deserialize($contents, CreateCustomerResponse::class);
		if ($apiResponse->isSuccessful()
			&& $apiResponse->getCustomerId())
			{
			return $apiResponse->getCustomerId();
			}

		return null;
		}

	/**
	 * @param int $id
	 * @return bool
	 * @throws ApiException
	 */
	public function deleteCustomer(int $id): bool
		{
		$url      = $this->getRestletUrl($this->createDeleteCustomerId, 3, [
			'customerid' => $id
		]);
		$contents = $this->executeDeleteRequest($url);
		/** @var DeleteCustomerResponse $response */
		$response = $this->serializer->deserialize($contents, DeleteCustomerResponse::class);

		return $response->isSuccessful();
		}

	/**
	 * @param string $pib
	 * @return Customer|null
	 * @throws ApiException
	 */
	public function findCustomerByPib(string $pib): ?Customer
		{
		$filters = [[
			'name'     => 'custentity_pib',
			'operator' => 'is',
			'values'   => [$pib]
		]];
		$results = $this->executeSavedSearchCustomers($filters);
		if (!empty($results->getCustomers()))
			{
			return $results->getCustomers()[0];
			}

		return null;
		}

	/**
	 * @param string $pib
	 * @return Customer|null
	 * @throws ApiException
	 */
	public function findCustomerByPibFragment(string $pib): ?Customer
		{
		$filters = [[
			'name'     => 'custentity_pib',
			'operator' => 'contains',
			'values'   => [$pib]
		]];
		$results = $this->executeSavedSearchCustomers($filters);
		if (!empty($results->getCustomers()))
			{
			return $results->getCustomers()[0];
			}

		return null;
		}

	/**
	 * @param string $registryIdentifier
	 * @return Customer|null
	 * @throws ApiException
	 */
	public function findCustomerByRegistryIdentifier(string $registryIdentifier): ?Customer
		{
		$filters = [[
			'name'     => 'custentity_matbrpred',
			'operator' => 'is',
			'values'   => [$registryIdentifier]
		]];
		$results = $this->executeSavedSearchCustomers($filters);
		if (!empty($results->getCustomers()))
			{
			return $results->getCustomers()[0];
			}

		return null;
		}

	/**
	 * @return Subsidiary[]
	 * @throws ApiException
	 */
	public function getSubsidiaries(): array
		{
		return $this->executeSuiteQuery(
			GetSubsidiariesResponse::class,
			'select parent, id , name from subsidiary'
		);
		}

	/**
	 * @return Department[]
	 * @throws ApiException
	 */
	public function getDepartments(): array
		{
		return $this->executeSuiteQuery(
			GetDepartmentsResponse::class,
			'select parent, id , name from department'
		);
		}

	/**
	 * @return Location[]
	 * @throws ApiException
	 */
	public function getLocations(): array
		{
		return $this->executeSuiteQuery(
			GetLocationsResponse::class,
			'select id, name, parent from location'
		);
		}

	/**
	 * @param array $filters
	 * @return SavedSearchCustomersResponse
	 * @throws ApiException
	 */
	private function executeSavedSearchCustomers(array $filters): SavedSearchCustomersResponse
		{
		$url         = $this->getRestletUrl($this->savedSearchCustomersId, 1);
		$requestBody = [
			'filters' => $filters
		];
		$contents    = $this->executePostRequest($url, $requestBody);
		/** @var SavedSearchCustomersResponse $response */
		$response = $this->serializer->deserialize($contents, SavedSearchCustomersResponse::class);

		return $response;
		}

	/**
	 * @param string|null $responseClass
	 * @param string $from
	 * @param string $where
	 * @param array $params
	 * @return array
	 * @throws ApiException
	 */
	public function executeSuiteQuery(
		?string $responseClass,
		string $from,
		$where = ' ',
		$params = []
	): array
		{
		$requestBody = [
			'sql_from'  => $from,
			'sql_where' => $where,
			'params'    => $params
		];
		$url         = $this->getRestletUrl($this->suiteQLId, 1);
		$contents    = $this->executePostRequest($url, $requestBody);
		if ($responseClass)
			{
			/** @var SuiteQLResponse $response */
			$response = $this->serializer->deserialize($contents, $responseClass);

			return !empty($response->getRows()) ? $response->getRows() : [];
			}

		return json_decode($contents, true);
		}

	/**
	 * @param string $url
	 * @param array $requestBody
	 * @return string
	 * @throws ApiException
	 */
	private function executePostRequest(string $url, array $requestBody): string
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
			throw ApiException::fromGuzzleException($exception);
			}

		if ($clientResponse->getStatusCode() !== 200)
			{
			throw ApiException::fromStatusCode($clientResponse->getStatusCode());
			}

		return $clientResponse->getBody()->getContents();
		}

	/**
	 * @param string $url
	 * @return string
	 * @throws ApiException
	 */
	private function executeDeleteRequest(string $url): string
		{
		try
			{
			$clientResponse = $this->client->request('DELETE', $url, [
				RequestOptions::HEADERS => $this->buildHeaders('DELETE', $url)
			]);
			}
		catch (GuzzleException $exception)
			{
			throw ApiException::fromGuzzleException($exception);
			}

		if ($clientResponse->getStatusCode() !== 200)
			{
			throw ApiException::fromStatusCode($clientResponse->getStatusCode());
			}

		return $clientResponse->getBody()->getContents();
		}

	/**
	 * @param int $scriptId
	 * @param int $deploymentId
	 * @param array $additionalQueryParams
	 * @return string
	 */
	private function getRestletUrl(int $scriptId, int $deploymentId, $additionalQueryParams = []): string
		{
		$queryParams = array_merge([
			'script' => $scriptId,
			'deploy' => $deploymentId
		], $additionalQueryParams);

		return sprintf('https://%s.restlets.api.netsuite.com/app/site/hosting/restlet.nl?', $this->account)
			. http_build_query($queryParams);
		}

	/**
	 * @param string $method
	 * @param string $url
	 * @return array
	 * @throws ApiException
	 */
	private function buildHeaders(string $method, string $url): array
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

		try
			{
			return [
				'Authorization' => substr($request->to_header($this->account), 15),
				'Host'          => $this->restletHost,
				'Content-Type'  => 'application/json'
			];
			}
		catch (OAuthException $exception)
			{
			throw ApiException::fromOAuthException($exception);
			}
		}

	/**
	 * @param string $path
	 * @return array
	 * @throws RuntimeException
	 */
	private function readJsonConfig(string $path): array
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
