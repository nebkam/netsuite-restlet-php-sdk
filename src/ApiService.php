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
use Infostud\NetSuiteSdk\Exception\ApiLogicException;
use Infostud\NetSuiteSdk\Exception\ApiTransferException;
use Infostud\NetSuiteSdk\Model\Contact\DeleteContactResponse;
use Infostud\NetSuiteSdk\Model\Customer\CreateCustomerResponse;
use Infostud\NetSuiteSdk\Model\Customer\CustomerForm;
use Infostud\NetSuiteSdk\Model\Customer\DeleteCustomerResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\CreateSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\DeleteSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderForm;
use Infostud\NetSuiteSdk\Model\Contact\ContactForm;
use Infostud\NetSuiteSdk\Model\Contact\CreateContactResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Contact;
use Infostud\NetSuiteSdk\Model\SavedSearch\ContactSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SavedSearch\CustomerSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Item;
use Infostud\NetSuiteSdk\Model\SavedSearch\ItemSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\TaxItem;
use Infostud\NetSuiteSdk\Model\SavedSearch\TaxItemSearchResponse;
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
	 * @var int
	 */
	private $createDeleteSalesOrderId;
	/**
	 * @var int
	 */
	private $savedSearchGenericId;
	/**
	 * @var int
	 */
	private $createDeleteContactId;

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
		$this->createDeleteSalesOrderId = $config['restletIds']['createDeleteSalesOrder'];
		$this->savedSearchGenericId   = $config['restletIds']['savedSearchGeneric'];
		$this->createDeleteContactId  = $config['restletIds']['createDeleteContact'];
		}

	/**
	 * @param CustomerForm $customerForm
	 * @return int
	 * @throws ApiTransferException|ApiLogicException
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

		throw new ApiLogicException($apiResponse->getErrorName(), $apiResponse->getErrorMessage());
		}

	/**
	 * @param int $id
	 * @return bool
	 * @throws ApiTransferException
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
	 * @param SalesOrderForm $form
	 * @return int
	 * @throws ApiTransferException|ApiLogicException
	 */
	public function createSalesOrder(SalesOrderForm $form)
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

		throw new ApiLogicException($apiResponse->getErrorName(), $apiResponse->getErrorMessage());
		}

	/**
	 * Used by tests only. Production usage not explicitly confirmed yet
	 *
	 * @param int $id
	 * @return bool
	 * @throws ApiTransferException
	 * @internal
	 */
	public function deleteSalesOrder($id)
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
	 * @param ContactForm $contactForm
	 * @return int
	 * @throws ApiTransferException|ApiLogicException
	 */
	public function createContact(ContactForm $contactForm)
		{
		$url         = $this->getRestletUrl($this->createDeleteContactId, 1);
		$requestBody = $this->serializer->normalize($contactForm);
		$contents = $this->executePostRequest($url, $requestBody);
		/** @var CreateContactResponse $response */
		$response = $this->serializer->deserialize($contents, CreateContactResponse::class);
		if ($response->isSuccessful()
			&& $response->getContactId())
			{
			return $response->getContactId();
			}

		throw new ApiLogicException($response->getErrorName(), $response->getErrorMessage());
		}

	/**
	 * Used by tests only. Production usage not explicitly confirmed yet
	 *
	 * @param int $id
	 * @return bool
	 * @throws ApiTransferException
	 * @internal
	 */
	public function deleteContact($id)
		{
		$url = $this->getRestletUrl($this->createDeleteContactId, 1, [
			'contactid' => $id
		]);
		$contents = $this->executeDeleteRequest($url);
		/** @var DeleteContactResponse $apiResponse */
		$apiResponse = $this->serializer->deserialize($contents, DeleteContactResponse::class);

		return $apiResponse->isSuccessful();
		}

	/**
	 * @param string $pib
	 * @return Customer|null
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @param DateTime $periodStart
	 * @param null $subsidiary
	 * @param null $location
	 * @param null $classification
	 * @return Item[]
	 * @throws ApiTransferException
	 */
	public function findRecentItems(DateTime $periodStart, $subsidiary = null, $location = null, $classification = null)
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
	 * Get all contacts for a selected company
	 *
	 * @param string $companyId
	 * @return Contact[]
	 * @throws ApiTransferException
	 */
	public function findContactsByCompany($companyId)
		{
		$filters = [[
			            'name'     => 'company',
			            'operator' => 'is',
			            'values'   => [$companyId]
		            ]];
		$columns = ['entityid', 'email', 'mobilephone', 'company','custentity_contact_location'];
		$results = $this->executeSavedSearchContacts($columns,$filters);
		return $results->getRows();
		}

	/**
	 * Get all contacts for a selected company
	 *
	 * @param string $name
	 * @return TaxItem[]
	 */
	public function findTaxItems($name = null)
		{
		$filters = [];

		if (!is_null($name))
			{
			$filters = [[
				            'name'     => 'name',
				            'operator' => 'is',
				            'values'   => [$name]
			            ]];
			}
		$columns = ['name', 'rate', 'country'];
		$results = $this->executeSavedSearchTaxItems($columns,$filters);
		return $results->getRows();
		}

	/**
	 * @return Subsidiary[]
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @param array $filters
	 * @return ContactSearchResponse
	 * @throws ApiTransferException
	 */
	private function executeSavedSearchContacts($columns, $filters)
		{
		$url = $this->getRestletUrl($this->savedSearchGenericId, 1);

		$columnArray = [];
		foreach($columns as $columnName)
			{
			$columnArray[] = ['name' => $columnName];
			}

		$requestBody    = [
			'type' => 'contact',
			'columns' => $columnArray,
			'filters' => $filters,
		];
		$contents = $this->executePostRequest($url, $requestBody);
		/** @var ContactSearchResponse $response */
		$response = $this->serializer->deserialize($contents, ContactSearchResponse::class);
		return $response;
		}

	/**
	 * @param array $filters
	 * @return TaxItemSearchResponse
	 * @throws ApiTransferException
	 */
	private function executeSavedSearchTaxItems($columns, $filters)
		{
		$url = $this->getRestletUrl($this->savedSearchGenericId, 1);

		$columnArray = [];
		foreach($columns as $columnName)
			{
			$columnArray[] = ['name' => $columnName];
			}

		$requestBody    = [
			'type' => 'salestaxitem',
			'columns' => $columnArray,
			'filters' => $filters,
		];
		$contents = $this->executePostRequest($url, $requestBody);
		/** @var TaxItemSearchResponse $response */
		$response = $this->serializer->deserialize($contents, TaxItemSearchResponse::class);
		return $response;
		}

	/**
	 * @param string|null $responseClass
	 * @param string $from
	 * @param string $where
	 * @param array $params
	 * @return array|mixed
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
			throw ApiTransferException::fromGuzzleException($exception);
			}

		if ($clientResponse->getStatusCode() !== 200)
			{
			throw ApiTransferException::fromStatusCode($clientResponse->getStatusCode());
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
	 * @throws ApiTransferException
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
			throw ApiTransferException::fromOAuthException($exception);
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
