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
use Infostud\NetSuiteSdk\Model\SavedSearch\CustomerSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Item;
use Infostud\NetSuiteSdk\Model\SavedSearch\ItemSearchResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Department;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetDepartmentsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetLocationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetSubsidiariesResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetClassificationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetEmployeesResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Location;
use Infostud\NetSuiteSdk\Model\SuiteQL\Subsidiary;
use Infostud\NetSuiteSdk\Model\SuiteQL\Classification;
use Infostud\NetSuiteSdk\Model\SuiteQL\Employee;
use Infostud\NetSuiteSdk\Model\SuiteQL\SuiteQLResponse;
use Infostud\NetSuiteSdk\Serializer\ApiSerializer;
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
		$this->createDeleteCustomerId = $config['restletIds']['createDeleteCustomer'];
		$this->savedSearchItemId      = $config['restletIds']['savedSearchItems'];
		}

	/**
	 * @param CustomerForm $customerForm
	 * @return int|null
	 * @throws ApiException
	 */
	public function createCustomer(CustomerForm $customerForm)
		{
		$url         = $this->getRestletUrl($this->createDeleteCustomerId, 3);
		$requestBody = $this->serializer->normalize($customerForm);
		$contents = $this->executePostRequest($url, $requestBody);
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
	public function deleteCustomer($id)
		{
		$url = $this->getRestletUrl($this->createDeleteCustomerId, 3, [
			'customerid' => $id
		]);
		$contents = $this->executeDeleteRequest($url);
		/** @var DeleteCustomerResponse $apiResponse */
		$apiResponse = $this->serializer->deserialize($contents, DeleteCustomerResponse::class);

		return $apiResponse->isSuccessful();
		}

	/**
	 * @param string $pib
	 * @return Customer|null
	 * @throws ApiException
	 */
	public function findCustomerByPib($pib)
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
	public function findCustomerByPibFragment($pib)
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
	 * Find a company by MBR or an individual by JMBG
	 *
	 * @param string $registryIdentifier
	 * @return Customer|null
	 * @throws ApiException
	 */
	public function findCustomerByRegistryIdentifier($registryIdentifier)
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
	 * @param string $registryIdentifier
	 * @return Customer|null
	 */
	public function findRecentItems(\DateTime $periodStart,$subsidiary = null, $location = null, $classification = null)
		{
		$filters[] = [
			'name'     => 'lastmodifieddate',
			'operator' => 'notbefore',
			'values'   => [$periodStart->format('d.m.Y H:i')]
			];

		if (!is_null($subsidiary))
			{
			$filters[] = [
				'name' => 'subsidiary',
				'operator' => 'is',
				'values' => [$subsidiary]
				];
			}
		if (!is_null($location))
			{
			$filters[] = [
				'name' => 'location',
				'operator' => 'is',
				'values' => [$location]
			];
			}
		if (!is_null($classification))
			{
			$filters[] = [
				'name' => 'class',
				'operator' => 'is',
				'values' => [$classification]
			];
			}

		$results = $this->executeSavedSearchItems($filters);
		return $results->getItems();
		}

	/**
	 * @return Subsidiary[]
	 * @throws ApiException
	 */
	public function getSubsidiaries()
		{
		return $this->executeSuiteQuery(
			GetSubsidiariesResponse::class,
			'select id, name, parent from subsidiary'
		);
		}

	/**
	 * @return Department[]
	 * @throws ApiException
	 */
	public function getDepartments()
		{
		return $this->executeSuiteQuery(
			GetDepartmentsResponse::class,
			'select id, name, parent from department'
		);
		}

	/**
	 * @return Location[]
	 * @throws ApiException
	 */
	public function getLocations()
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
	public function getClassifications()
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
	public function getEmployees()
		{
		return $this->executeSuiteQuery(
			GetEmployeesResponse::class,
			'select id, entityid from employee'
		);
		}

	/**
	 * @param array $filters
	 * @return CustomerSearchResponse
	 * @throws ApiException
	 */
	private function executeSavedSearchCustomers($filters)
		{
		$url            = $this->getRestletUrl($this->savedSearchCustomersId, 1);
		$requestBody    = [
			'filters' => $filters
		];
		$contents = $this->executePostRequest($url, $requestBody);
		/** @var CustomerSearchResponse $response */
		$response = $this->serializer->deserialize($contents, CustomerSearchResponse::class);

		return $response;
		}

	/**
	 * @param array $filters
	 * @return ItemSearchResponse
	 * @throws ApiException
	 */
	private function executeSavedSearchItems($filters)
		{
		$url            = $this->getRestletUrl($this->savedSearchItemId, 1);
		$requestBody    = [
			'filters' => $filters
		];
		$contents = $this->executePostRequest($url, $requestBody);
		/** @var ItemSearchResponse $response */
		$response = $this->serializer->deserialize($contents, ItemSearchResponse::class);

		return $response;
		}

	/**
	 * @param string|null $responseClass
	 * @param string $from
	 * @param string $where
	 * @param array $params
	 * @return array|mixed
	 * @throws ApiException
	 */
	public function executeSuiteQuery($responseClass, $from, $where = ' ', $params = [])
		{
		$url         = $this->getRestletUrl($this->suiteQLId, 1);
		$requestBody = [
			'sql_from'  => $from,
			'sql_where' => $where,
			'params'    => $params
		];
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
	private function executePostRequest($url, array $requestBody)
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
	private function executeDeleteRequest($url)
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
	 * @param array $additionalQueryData
	 * @return string
	 */
	private function getRestletUrl($scriptId, $deploymentId, $additionalQueryData = [])
		{
		$queryData = array_merge([
			'script' => $scriptId,
			'deploy' => $deploymentId
		], $additionalQueryData);

		return sprintf('https://%s.restlets.api.netsuite.com/app/site/hosting/restlet.nl?', $this->account)
			. http_build_query($queryData);
		}

	/**
	 * @param $method
	 * @param string $url
	 * @return array
	 * @throws ApiException
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
