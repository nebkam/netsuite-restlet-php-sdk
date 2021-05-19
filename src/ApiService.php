<?php

namespace Infostud\NetSuiteSdk;

use DateTime;
use Infostud\NetSuiteSdk\Exception\ApiTransferException;
use Infostud\NetSuiteSdk\Exception\ApiLogicException;
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
use Infostud\NetSuiteSdk\Model\SalesOrder\GetSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrder;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderForm;
use Infostud\NetSuiteSdk\Model\SalesOrder\DeleteSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Contact;
use Infostud\NetSuiteSdk\Model\SavedSearch\ContactSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SavedSearch\GenericSavedSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\GetPaymentsResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\Item;
use Infostud\NetSuiteSdk\Model\SavedSearch\ItemSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\NotificationRecipient;
use Infostud\NetSuiteSdk\Model\SavedSearch\NotificationRecipientSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\TaxItem;
use Infostud\NetSuiteSdk\Model\SavedSearch\TaxItemSearchResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Classification;
use Infostud\NetSuiteSdk\Model\SuiteQL\Employee;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetClassificationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetEmployeesResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetItemsFilter;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetItemsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetLocationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetSubsidiariesResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\SavedSearchCustomersResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Department;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetDepartmentsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\Item as SuiteQLItem;
use Infostud\NetSuiteSdk\Model\SuiteQL\Location;
use Infostud\NetSuiteSdk\Model\SuiteQL\Subsidiary;
use Infostud\NetSuiteSdk\Model\SuiteQL\SuiteQLResponse;
use Psr\Log\LoggerInterface;

class ApiService
	{
	/**
	 * @var ApiSerializer
	 */
	private $serializer;
	/**
	 * @var ApiConfig
	 */
	private $config;
	/**
	 * @var ApiClient
	 */
	private $client;

	/**
	 * @param string $configPath
	 * @param LoggerInterface|null $logger
	 * @throws ApiTransferException
	 */
	public function __construct(string $configPath, ?LoggerInterface $logger = null)
		{
		$this->serializer = new ApiSerializer();
		$this->config     = ApiConfig::fromJsonFile($configPath, $this->serializer);
		$this->client     = new ApiClient($this->config, $logger);
		}

	/**
	 * @param ContactForm $contactForm
	 * @return int
	 * @throws ApiTransferException|ApiLogicException
	 */
	public function createContact(ContactForm $contactForm): int
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
	public function deleteContact(int $id): bool
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
	 * @param CustomerForm $form
	 * @return int
	 * @throws ApiTransferException
	 * @throws ApiLogicException
	 */
	public function createCustomer(CustomerForm $form): int
		{
		$url         = $this->config->getRestletUrl($this->config->restletMap->createDeleteCustomer);
		$requestBody = $this->serializer->normalize($form);
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
	 * Since deleting a Customer can have unpredictable side-effects
	 * if the Customer entity has relations to SalesOrders or other entities
	 * this method should only be used in tests.
	 * In production, setting the Customer to inactive is the recommended alternative.
	 *
	 * @param int $id
	 * @return bool
	 * @throws ApiTransferException
	 * @internal
	 */
	public function deleteCustomer(int $id): bool
		{
		$url      = $this->config->getRestletUrl($this->config->restletMap->createDeleteCustomer, [
			'customerid' => $id
		]);
		$contents = $this->client->delete($url);
		/** @var DeleteCustomerResponse $response */
		$response = $this->serializer->deserialize($contents, DeleteCustomerResponse::class);

		return $response->isSuccessful();
		}

	/**
	 * @param NotificationRecipientForm $form
	 * @return int
	 * @throws ApiTransferException|ApiLogicException
	 */
	public function createNotificationRecipient(NotificationRecipientForm $form): int
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
	public function deleteNotificationRecipient(int $id): bool
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
	 * @param SalesOrderForm $form
	 * @return int
	 * @throws ApiTransferException|ApiLogicException
	 */
	public function createSalesOrder(SalesOrderForm $form): int
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
	 * @param int $orderId
	 * @return SalesOrder
	 * @throws ApiLogicException
	 * @throws ApiTransferException
	 */
	public function getSalesOrder(int $orderId): SalesOrder
		{
		$url      = $this->config->getRestletUrl($this->config->restletMap->getSalesOrder, [
			'orderid' => $orderId
		]);
		$contents = $this->client->get($url);

		/** @var GetSalesOrderResponse $apiResponse */
		$apiResponse = $this->serializer->deserialize($contents, GetSalesOrderResponse::class);
		if ($apiResponse->isSuccessful()
			&& $apiResponse->getSalesOrder())
			{
			return $apiResponse->getSalesOrder();
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
	public function deleteSalesOrder(int $id): bool
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
	 * @param string $pib
	 * @return Customer|null
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @param string $oldErpId
	 * @return Customer|null
	 * @throws ApiTransferException
	 */
	public function findCustomerByOldErpId(string $oldErpId): ?Customer
		{
		$filters = [[
			'name'     => 'custentity_cus_crm_id',
			'operator' => 'is',
			'values'   => [$oldErpId]
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
	 * Get all contacts for a selected company
	 *
	 * @param int $companyId
	 * @return Contact[]
	 * @throws ApiTransferException
	 */
	public function findContactsByCompany(int $companyId): array
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
	 * @param int $customerId
	 * @param null $location
	 * @return NotificationRecipient[]
	 * @throws ApiTransferException
	 */
	public function findNotificationRecipients(int $customerId, $location = null): array
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
	 * @param string $name
	 * @return TaxItem[]
	 * @throws ApiTransferException
	 */
	public function findTaxItems($name = null): array
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
	 * @return Subsidiary[]
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
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
	 * @throws ApiTransferException
	 */
	public function getEmployees(): array
		{
		return $this->executeSuiteQuery(
			GetEmployeesResponse::class,
			'select id, entityid from employee'
		);
		}

	/**
	 * @param GetItemsFilter|null $filter
	 * @return SuiteQLItem[]
	 * @throws ApiTransferException
	 */
	public function getItems(?GetItemsFilter $filter = null): array
		{
		return $this->executeSuiteQuery(
			GetItemsResponse::class,
			'select id, custitem_item_old_erp_id, fullname from item',
			$filter !== null ? $filter->getWhereString() : ''
		);
		}

	/**
	 * @param int $subsidiaryId
	 * @param DateTime $startDate
	 * @param DateTime $endDate
	 * @return GetPaymentsResponse
	 * @throws ApiTransferException
	 */
	public function getPayments(int $subsidiaryId, DateTime $startDate, DateTime $endDate): GetPaymentsResponse
		{
		$url = $this->config->getRestletUrl($this->config->restletMap->getPayments);
		$contents = $this->client->post($url,[
			'subsidiaryId' => $subsidiaryId,
			'startDate'    => $startDate->format('d.m.Y H:i'),
			'endDate'      => $endDate->format('d.m.Y H:i'),
		]);

		/** @var GetPaymentsResponse $response */
		$response = $this->serializer->deserialize($contents, GetPaymentsResponse::class);
		return $response;
		}
	/**
	 * @return false|string
	 * @throws ApiLogicException
	 * @throws ApiTransferException
	 */
	public function downloadPdf()
		{
		$params = []; //TODO As this uses GET method, parameters need to be passed through URL

		$url      = $this->config->getRestletUrl($this->config->restletMap->downloadPdf, $params);
		$contents = $this->client->get($url, 'application/pdf');
		if (empty($contents))
			{
			throw new ApiLogicException('Empty response', 'Server has returned empty string for given parameters');
			}

		return base64_decode($contents);
		}

	/**
	 * @param array $filters
	 * @return SavedSearchCustomersResponse
	 * @throws ApiTransferException
	 */
	private function executeSavedSearchCustomers(array $filters): SavedSearchCustomersResponse
		{
		$url         = $this->config->getRestletUrl($this->config->restletMap->savedSearchCustomers);
		$requestBody = [
			'filters' => $filters
		];
		$contents    = $this->client->post($url, $requestBody);
		/** @var SavedSearchCustomersResponse $response */
		$response = $this->serializer->deserialize($contents, SavedSearchCustomersResponse::class);

		return $response;
		}

	/**
	 * @param array $filters
	 * @return ItemSearchResponse
	 * @throws ApiTransferException
	 */
	private function executeSavedSearchItems(array $filters): ItemSearchResponse
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
	private function executeGenericSavedSearch(
		string $type,
		array $columnNames,
		array $filters,
		string $responseClass
	): array
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
	 * @return array
	 * @throws ApiTransferException
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
		$url         = $this->config->getRestletUrl($this->config->restletMap->suiteQL);
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
