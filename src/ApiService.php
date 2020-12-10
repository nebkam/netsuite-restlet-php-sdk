<?php

namespace Infostud\NetSuiteSdk;

use DateTime;
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
use Infostud\NetSuiteSdk\Exception\NetSuiteException;
use Infostud\NetSuiteSdk\Model\Customer\CreateCustomerResponse;
use Infostud\NetSuiteSdk\Model\Customer\CustomerForm;
use Infostud\NetSuiteSdk\Model\Customer\DeleteCustomerResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\CreateSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderForm;
use Infostud\NetSuiteSdk\Model\SalesOrder\DeleteSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SavedSearch\Item;
use Infostud\NetSuiteSdk\Model\SavedSearch\ItemSearchResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Classification;
use Infostud\NetSuiteSdk\Model\SuiteQL\Employee;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetClassificationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetEmployeesResponse;
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
	 * @var int
	 */
	private $savedSearchItemId;
	/**
	 * @var int
	 */
	private $createDeleteSalesOrderId;

	/**
	 * @param string $configPath
	 */
	public function __construct(string $configPath)
		{
		$config = $this->readJsonConfig($configPath);

		$this->account                  = $config['account'];
		$this->restletHost              = $config['account'] . '.restlets.api.netsuite.com';
		$this->client                   = new Client();
		$this->consumer                 = new Consumer(
			$config['consumerKey'], $config['consumerSecret']
		);
		$this->accessToken              = new Token(
			$config['accessTokenKey'], $config['accessTokenSecret']
		);
		$this->signatureMethod          = new HmacSha1();
		$this->serializer               = new ApiSerializer();
		$this->savedSearchCustomersId   = $config['restletIds']['savedSearchCustomers'];
		$this->suiteQLId                = $config['restletIds']['suiteQL'];
		$this->createDeleteCustomerId   = $config['restletIds']['createDeleteCustomer'];
		$this->savedSearchItemId        = $config['restletIds']['savedSearchItems'];
		$this->createDeleteSalesOrderId = $config['restletIds']['createDeleteSalesOrder'];
		}

	/**
	 * @param CustomerForm $form
	 * @return int|null
	 * @throws ApiException
	 */
	public function createCustomer(CustomerForm $form): ?int
		{
		$url         = $this->getRestletUrl($this->createDeleteCustomerId, 3);
		$requestBody = $this->serializer->normalize($form);
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
	 * Since deleting a Customer can have unpredictable side-effects
	 * if the Customer entity has relations to SalesOrders or other entities
	 * this method should only be used in tests.
	 * In production, setting the Customer to inactive is the recommended alternative.
	 *
	 * @param int $id
	 * @return bool
	 * @throws ApiException
	 * @internal
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
	 * @param SalesOrderForm $form
	 * @return int
	 * @throws ApiException|NetSuiteException
	 */
	public function createSalesOrder(SalesOrderForm $form): int
		{
		$url         = $this->getRestletUrl($this->createDeleteSalesOrderId, 1);
		$requestBody = $this->serializer->normalize($form);
		$contents    = $this->executePostRequest($url, $requestBody);
		/** @var CreateSalesOrderResponse $apiResponse */
		$apiResponse = $this->serializer->deserialize($contents, CreateSalesOrderResponse::class);
		if ($apiResponse->isSuccessful()
			&& $apiResponse->getOrderId())
			{
			return $apiResponse->getOrderId();
			}

		throw new NetSuiteException($apiResponse->getErrorName(), $apiResponse->getErrorMessage());
		}

	/**
	 * Used by tests only. Production usage not explicitly confirmed yet
	 *
	 * @param int $id
	 * @return bool
	 * @throws ApiException
	 * @internal
	 */
	public function deleteSalesOrder(int $id): bool
		{
		$url      = $this->getRestletUrl($this->createDeleteSalesOrderId, 1, [
			'orderid' => $id
		]);
		$contents = $this->executeDeleteRequest($url);
		/** @var DeleteSalesOrderResponse $response */
		$response = $this->serializer->deserialize($contents, DeleteSalesOrderResponse::class);

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
	 * Find recently created items in specific subsidiaries, locations or classes
	 *
	 * @param DateTime $periodStart
	 * @param null $subsidiary
	 * @param null $location
	 * @param null $classification
	 * @return Item[]
	 * @throws ApiException
	 */
	public function findRecentItems(DateTime $periodStart, $subsidiary = null, $location = null, $classification = null): array
		{
		$filters[] = [
			'name'     => 'lastmodifieddate',
			'operator' => 'notbefore',
			'values'   => [$periodStart->format('d.m.Y H:i')]
		];

		if (!is_null($subsidiary))
			{
			$filters[] = [
				'name'     => 'subsidiary',
				'operator' => 'is',
				'values'   => [$subsidiary]
			];
			}
		if (!is_null($location))
			{
			$filters[] = [
				'name'     => 'location',
				'operator' => 'is',
				'values'   => [$location]
			];
			}
		if (!is_null($classification))
			{
			$filters[] = [
				'name'     => 'class',
				'operator' => 'is',
				'values'   => [$classification]
			];
			}

		$results = $this->executeSavedSearchItems($filters);

		return $results->getItems();
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
	 * @return Classification[]
	 * @throws ApiException
	 */
	public function getClassifications(): array
		{
		return $this->executeSuiteQuery(
			GetClassificationsResponse::class,
			'select id, name from classification'
		);
		}

	/**
	 * @return Employee[]
	 * @throws ApiException
	 */
	public function getEmployees(): array
		{
		return $this->executeSuiteQuery(
			GetEmployeesResponse::class,
			'select id, entityid from employee'
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
	 * @param array $filters
	 * @return ItemSearchResponse
	 * @throws ApiException
	 */
	private function executeSavedSearchItems(array $filters): ItemSearchResponse
		{
		$url         = $this->getRestletUrl($this->savedSearchItemId, 1);
		$requestBody = [
			'filters' => $filters
		];
		$contents    = $this->executePostRequest($url, $requestBody);
		/** @var ItemSearchResponse $response */
		$response = $this->serializer->deserialize($contents, ItemSearchResponse::class);

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
