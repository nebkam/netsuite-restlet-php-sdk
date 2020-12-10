<?php

use Infostud\NetSuiteSdk\ApiService;
use Infostud\NetSuiteSdk\Exception\ApiLogicException;
use Infostud\NetSuiteSdk\Exception\ApiTransferException;
use Infostud\NetSuiteSdk\Model\Contact\ContactForm;
use Infostud\NetSuiteSdk\Model\Customer\CustomerForm;
use Infostud\NetSuiteSdk\Model\Customer\CustomerFormAddress;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderForm;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderItem;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SavedSearch\Item;
use Infostud\NetSuiteSdk\Model\SuiteQL\Classification;
use Infostud\NetSuiteSdk\Model\SuiteQL\Department;
use Infostud\NetSuiteSdk\Model\SuiteQL\Employee;
use Infostud\NetSuiteSdk\Model\SuiteQL\Location;
use Infostud\NetSuiteSdk\Model\SuiteQL\Subsidiary;
use PHPUnit\Framework\TestCase;

class ApiServiceTest extends TestCase
	{
	/**
	 * Test that it doesn't throw exceptions
	 * @return ApiService
	 */
	public function testParseConfig()
		{
		$configPath = getenv('CONFIG_PATH');

		return new ApiService($configPath);
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @return array
	 * @throws ApiTransferException|ApiLogicException
	 */
	public function testCreateCustomer(ApiService $apiService)
		{
		$customerForm = (new CustomerForm())
			->setExternalId('PIB-123456')
			->setCompanyName('Foo test customer')
			->setSubsidiary(10)
			->setVatIdentifier('101696893')
			->setRegistryIdentifier('01234567')
			->addAddress(
				(new CustomerFormAddress())
					->setLabel('Nazor')
					->setCity('Subotica')
					->setAddressLine1('Vladimira Nazora 7')
					->setAddressLine2('(u pasažu)')
					->setPostalCode('24000')
					->setCountry(CustomerFormAddress::COUNTRY_SERBIA)
			);
		$customerId   = $apiService->createCustomer($customerForm);
		self::assertNotNull($customerId);

		return [
			$apiService,
			$customerId
		];
		}

	/**
	 * @depends testCreateCustomer
	 * @param $params array
	 * @return array
	 * @throws ApiLogicException
	 * @throws ApiTransferException
	 */
	public function testCreateContact($params)
		{
		/**
		 * @var $apiService ApiService
		 * @var $customerId int
		 */
		list($apiService, $customerId) = $params;
		$form = (new ContactForm())
			->setSubsidiary(getenv('SUBSIDIARY_ID'))
			->setFirstName('Little Bobby')
			->setLastName('Tables')
			->setCustomerId($customerId);
		$contactId = $apiService->createContact($form);
		self::assertNotNull($contactId);

		return [
			$apiService,
			$contactId
			];
		}

	/**
	 * @depends testCreateContact
	 * @param array $params
	 * @throws ApiTransferException
	 */
	public function testDeleteContact($params)
		{
		/**
		 * @var $apiService ApiService
		 * @var $contactId int
		 */
		list($apiService, $contactId) = $params;
		self::assertTrue($apiService->deleteContact($contactId));
		}

	/**
	 * @depends testCreateCustomer
	 * @param array $params
	 * @return array
	 * @throws ApiTransferException
	 * @throws ApiLogicException
	 */
	public function testCreateSalesOrder(array $params)
		{
		/**
		 * @var $apiService ApiService
		 * @var $customerId int
		 */
		list($apiService, $customerId) = $params;
		$form = (new SalesOrderForm())
			->setSubsidiary(getenv('SUBSIDIARY_ID'))
			->setDepartment(getenv('DEPARTMENT_ID'))
			->setLocation(getenv('LOCATION_ID'))
			->setClassification(getenv('CLASSIFICATION_ID'))
			->setCustomer($customerId)
			->addItem(
				(new SalesOrderItem())
					->setId(getenv('ITEM_ID'))
					->setQuantity(1)
					->setRate(5000000.00)
					->setTaxCode(8)
			)
			->setTransactionDate('02.05.2020');
		$salesOrderId = $apiService->createSalesOrder($form);
		self::assertNotEmpty($salesOrderId);
		return [
			$apiService,
			$salesOrderId
		];
		}

	/**
	 * @depends testCreateSalesOrder
	 * @param array $param
	 * @throws ApiTransferException
	 */
	public function testDeleteSalesOrder(array $param)
		{
		/**
		 * @var ApiService $apiService
		 * @var int $salesOrderId
		 */
		list($apiService, $salesOrderId) = $param;
		$apiService->deleteSalesOrder($salesOrderId);
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testSearchByPib($apiService)
		{
		$customer = $apiService->findCustomerByPib('109121175');
		self::assertInstanceOf(Customer::class, $customer);
		self::assertEquals('109121175', $customer->getAttributes()->getPib());
		}

	/**
	 * TODO Add real foreign PIB
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testSearchByPibFragment($apiService)
		{
		$customer = $apiService->findCustomerByPibFragment('10912117');
		self::assertInstanceOf(Customer::class, $customer);
		self::assertEquals('109121175', $customer->getAttributes()->getPib());
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testSearchByRegistryIdentifier($apiService)
		{
		$customer = $apiService->findCustomerByRegistryIdentifier('63944017');
		self::assertInstanceOf(Customer::class, $customer);
		self::assertEquals('63944017', $customer->getAttributes()->getRegistryIdentifier());
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testFindRecentItems($apiService)
		{
		$items = $apiService->findRecentItems(new DateTime('-1 year'));
		self::assertContainsOnlyInstancesOf(Item::class, $items);
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testGetSubsidiaries($apiService)
		{
		$subsidiaries = $apiService->getSubsidiaries();
		self::assertNotEmpty($subsidiaries);
		foreach ($subsidiaries as $subsidiary)
			{
			self::assertInstanceOf(Subsidiary::class, $subsidiary);
			self::assertNotEmpty($subsidiary->getId());
			self::assertNotEmpty($subsidiary->getName());
			}
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testGetDepartments($apiService)
		{
		$departments = $apiService->getDepartments();
		self::assertNotEmpty($departments);
		foreach ($departments as $department)
			{
			self::assertInstanceOf(Department::class, $department);
			self::assertNotEmpty($department->getId());
			self::assertNotEmpty($department->getName());
			}
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testGetLocations($apiService)
		{
		$locations = $apiService->getLocations();
		self::assertNotEmpty($locations);
		foreach ($locations as $location)
			{
			self::assertInstanceOf(Location::class, $location);
			self::assertNotEmpty($location->getId());
			self::assertNotEmpty($location->getName());
			}
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testGetClassifications($apiService)
		{
		$classifications = $apiService->getClassifications();
		self::assertNotEmpty($classifications);
		foreach ($classifications as $classification)
			{
			self::assertInstanceOf(Classification::class, $classification);
			self::assertNotEmpty($classification->getId());
			self::assertNotEmpty($classification->getName());
			}
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testGetEmployees($apiService)
		{
		$employees = $apiService->getEmployees();
		self::assertNotEmpty($employees);
		foreach ($employees as $employee)
			{
			self::assertInstanceOf(Employee::class, $employee);
			self::assertNotEmpty($employee->getId());
			self::assertNotEmpty($employee->getName());
			}
		}

	/**
	 * @depends testCreateCustomer
	 * @param array $param
	 * @throws ApiTransferException
	 */
	public function testDeleteCustomer(array $param)
		{
		/**
		 * @var ApiService $apiService
		 * @var int $customerId
		 */
		list($apiService, $customerId) = $param;
		self::assertTrue($apiService->deleteCustomer($customerId));
		}
	}
