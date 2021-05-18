<?php

namespace Infostud\NetSuiteSdk;

use DateTime;
use Infostud\NetSuiteSdk\Exception\ApiLogicException;
use Infostud\NetSuiteSdk\Exception\ApiTransferException;
use Infostud\NetSuiteSdk\Model\Contact\ContactForm;
use Infostud\NetSuiteSdk\Model\Contact\CreateContactResponse;
use Infostud\NetSuiteSdk\Model\Contact\DeleteContactResponse;
use Infostud\NetSuiteSdk\Model\Customer\CreateCustomerResponse;
use Infostud\NetSuiteSdk\Model\Customer\CustomerForm;
use Infostud\NetSuiteSdk\Model\Customer\DeleteCustomerResponse;
use Infostud\NetSuiteSdk\Model\NotificationRecipient\CreateNotificationRecipientResponse;
use Infostud\NetSuiteSdk\Model\NotificationRecipient\DeleteNotificationRecipientResponse;
use Infostud\NetSuiteSdk\Model\NotificationRecipient\NotificationRecipientForm;
use Infostud\NetSuiteSdk\Model\SalesOrder\CreateSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\DeleteSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderDataResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderForm;
use Infostud\NetSuiteSdk\Model\SavedSearch\Contact;
use Infostud\NetSuiteSdk\Model\SavedSearch\ContactSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SavedSearch\CustomerSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\GenericSavedSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\GetPaymentsResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Item;
use Infostud\NetSuiteSdk\Model\SavedSearch\ItemSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\NotificationRecipient;
use Infostud\NetSuiteSdk\Model\SavedSearch\NotificationRecipientSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\TaxItem;
use Infostud\NetSuiteSdk\Model\SavedSearch\TaxItemSearchResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Classification;
use Infostud\NetSuiteSdk\Model\SuiteQL\Department;
use Infostud\NetSuiteSdk\Model\SuiteQL\Employee;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetClassificationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetDepartmentsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetEmployeesResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetLocationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetSubsidiariesResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Location;
use Infostud\NetSuiteSdk\Model\SuiteQL\Subsidiary;
use Infostud\NetSuiteSdk\Model\SuiteQL\SuiteQLResponse;
use Infostud\NetSuiteSdk\Serializer\ApiSerializer;

class ApiService
	{
	/**
	 * @var ApiClient
	 */
	private $client;
	/**
	 * @var ApiSerializer
	 */
	private $serializer;
	/**
	 * @var ApiConfig
	 */
	private $config;

	/**
	 * @param string $configPath
	 */
	public function __construct($configPath)
		{
		$this->serializer = new ApiSerializer();
		$this->config     = ApiConfig::fromJsonFile($configPath, $this->serializer);
		$this->client     = new ApiClient($this->config);
		}

	/**
	 * @param CustomerForm $customerForm
	 * @return int
	 * @throws ApiTransferException|ApiLogicException
	 */
	public function createCustomer(CustomerForm $customerForm)
		{
		$url         = $this->config->getRestletUrl($this->config->restletMap->createDeleteCustomer);
		$requestBody = $this->serializer->normalize($customerForm);
		$contents    = $this->client->post($url, $requestBody);
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
		$url      = $this->config->getRestletUrl($this->config->restletMap->createDeleteCustomer, [
			'customerid' => $id
		]);
		$contents = $this->client->delete($url);
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
		$url         = $this->config->getRestletUrl($this->config->restletMap->createDeleteSalesOrder);
		$requestBody = $this->serializer->normalize($form);
		$contents    = $this->client->post($url, $requestBody);
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
		$url      = $this->config->getRestletUrl($this->config->restletMap->createDeleteSalesOrder, [
			'orderid' => $id
		]);
		$contents = $this->client->delete($url);
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
		$url         = $this->config->getRestletUrl($this->config->restletMap->createDeleteContact);
		$requestBody = $this->serializer->normalize($contactForm);
		$contents    = $this->client->post($url, $requestBody);
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
		$url      = $this->config->getRestletUrl($this->config->restletMap->createDeleteContact, [
			'contactid' => $id
		]);
		$contents = $this->client->delete($url);
		/** @var DeleteContactResponse $apiResponse */
		$apiResponse = $this->serializer->deserialize($contents, DeleteContactResponse::class);

		return $apiResponse->isSuccessful();
		}

	/**
	 * @param NotificationRecipientForm $form
	 * @return int
	 * @throws ApiTransferException|ApiLogicException
	 */
	public function createNotificationRecipient(NotificationRecipientForm $form)
		{
		$url         = $this->config->getRestletUrl($this->config->restletMap->createDeleteNotify);
		$requestBody = $this->serializer->normalize($form);
		$contents    = $this->client->post($url, $requestBody);
		/** @var CreateNotificationRecipientResponse $response */
		$response = $this->serializer->deserialize($contents, CreateNotificationRecipientResponse::class);
		if ($response->isSuccessful()
			&& $response->getNotificationRecipientId())
			{
			return $response->getNotificationRecipientId();
			}

		throw new ApiLogicException($response->getErrorName(), $response->getErrorMessage());
		}

	/**
	 * @param int $id
	 * @return bool
	 * @throws ApiTransferException
	 */
	public function deleteNotificationRecipient($id)
		{
		$url      = $this->config->getRestletUrl($this->config->restletMap->createDeleteNotify, [
			'contactid' => $id
		]);
		$contents = $this->client->delete($url);

		/** @var DeleteNotificationRecipientResponse $apiResponse */
		$apiResponse = $this->serializer->deserialize($contents, DeleteNotificationRecipientResponse::class);

		return $apiResponse->isSuccessful();
		}

	/**
	 * @param $orderId
	 *
	 * @return SalesOrderDataResponse
	 * @throws ApiTransferException
	 */
	public function salesOrderMetadata($orderId)
		{
		$url         = $this->config->getRestletUrl($this->config->restletMap->salesOrderMetaData);
		$requestBody = ['orderId' => $orderId];
		$contents    = $this->client->post($url, $requestBody);
		/** @var SalesOrderDataResponse $apiResponse */
		$apiResponse = $this->serializer->deserialize($contents, SalesOrderDataResponse::class);

		return $apiResponse;
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
	 * Get all contacts for a selected company
	 *
	 * @param int $companyId
	 * @return Contact[]
	 * @throws ApiTransferException
	 */
	public function findContactsByCompany($companyId)
		{
		$filters     = [[
			'name'     => 'company',
			'operator' => 'is',
			'values'   => [$companyId]
		]];
		$columnNames = [
			'entityid',
			'email',
			'mobilephone',
			'company',
			'custentity_contact_location'
		];

		return $this->executeGenericSavedSearch(
			'contact',
			$columnNames,
			$filters,
			ContactSearchResponse::class
		);
		}

	/**
	 * @param string $name
	 * @return TaxItem[]
	 * @throws ApiTransferException
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
		$columnNames = [
			'name',
			'rate',
			'country'
		];

		return $this->executeGenericSavedSearch(
			'salestaxitem',
			$columnNames,
			$filters,
			TaxItemSearchResponse::class
		);
		}

	/**
	 * @param int $customerId
	 * @param array $location
	 * @return NotificationRecipient[]
	 * @throws ApiTransferException
	 */
	public function findNotificationRecipients($customerId, $location = null)
		{
		$filters[] = [
			'name'     => 'custrecord_rsm_custnp_customer',
			'operator' => 'anyof',
			'values'   => [$customerId]
		];
		if (!empty($location))
			{
			$filters[] = [
				'name'     => 'custrecord_rsm_custnp_location',
				'operator' => 'anyof',
				'values'   => is_array($location) ? $location : [$location],
			];
			}
		$columnNames = [
			'custrecord_rsm_custnp_location',
			'custrecord_rsm_custnp_description',
			'custrecord_rsm_custnp_mailto',
			'custrecord_rsm_custnp_mailcc',
		];

		return $this->executeGenericSavedSearch(
			'customrecord_rsm_cust_notif_param',
			$columnNames,
			$filters,
			NotificationRecipientSearchResponse::class
		);
		}

	/**
	 * @param int $subsidiaryId
	 * @param DateTime $startDate
	 * @param DateTime $endDate
	 *
	 * @return GetPaymentsResponse
	 * @throws ApiTransferException
	 */
	public function getPayments($subsidiaryId, \DateTime $startDate, \DateTime $endDate)
		{
		$url         = $this->config->getRestletUrl($this->config->restletMap->getPayments);
		$requestBody = [
			'subsidiaryId' => $subsidiaryId,
			'startDate'    => $startDate->format('d.m.Y H:i'),
			'endDate'      => $endDate->format('d.m.Y H:i'),
		];
		$contents    = $this->client->post($url, $requestBody);

		/** @var GetPaymentsResponse $apiResponse */
		return $this->serializer->deserialize($contents, GetPaymentsResponse::class);
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
	 * @param $fileId
	 *
	 * @return false|string
	 * @throws ApiLogicException
	 * @throws ApiTransferException
	 */
	public function downloadPdf($fileId)
		{
		// As this uses GET method, parameters need to be passed through URL
		$extraParameters = [
			'fileId' => $fileId
		];

		$url      = $this->config->getRestletUrl($this->config->restletMap->downloadPdf, $extraParameters);
		$contents = $this->client->get($url);
		if (empty($contents))
			{
			throw new ApiLogicException('Empty response', 'Server has returned empty string for given parameters');
			}

		return base64_decode($contents);
		}

	/**
	 * @param array $filters
	 * @return CustomerSearchResponse
	 * @throws ApiTransferException
	 */
	private function executeSavedSearchCustomers($filters)
		{
		$url         = $this->config->getRestletUrl($this->config->restletMap->savedSearchCustomers);
		$requestBody = [
			'filters' => $filters
		];
		$contents    = $this->client->post($url, $requestBody);
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
		$url         = $this->config->getRestletUrl($this->config->restletMap->savedSearchItems);
		$requestBody = [
			'filters' => $filters
		];
		$contents    = $this->client->post($url, $requestBody);
		/** @var ItemSearchResponse $response */
		$response = $this->serializer->deserialize($contents, ItemSearchResponse::class);

		return $response;
		}

	/**
	 * @param string $type
	 * @param string[] $columnNames
	 * @param array $filters
	 * @param string $responseClass
	 * @return array
	 * @throws ApiTransferException
	 */
	private function executeGenericSavedSearch($type, $columnNames, $filters, $responseClass)
		{
		$url = $this->config->getRestletUrl($this->config->restletMap->savedSearchGeneric);

		$columns = array_map(static function ($columnName) {
			return ['name' => $columnName];
		}, $columnNames);

		$requestBody = [
			'type'    => $type,
			'columns' => $columns,
			'filters' => $filters,
		];
		$contents    = $this->client->post($url, $requestBody);
		/** @var GenericSavedSearchResponse $response */
		$response = $this->serializer->deserialize($contents, $responseClass);

		return !empty($response->getRows()) ? $response->getRows() : [];
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
		$url         = $this->config->getRestletUrl($this->config->restletMap->suiteQL);
		$requestBody = [
			'sql_from'  => $from,
			'sql_where' => $where,
			'params'    => $params
		];
		$contents    = $this->client->post($url, $requestBody);
		if ($responseClass)
			{
			/** @var SuiteQLResponse $response */
			$response = $this->serializer->deserialize($contents, $responseClass);

			return !empty($response->getRows()) ? $response->getRows() : [];
			}

		return json_decode($contents, true);
		}
	}
