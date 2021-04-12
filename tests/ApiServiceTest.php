<?php

use Infostud\NetSuiteSdk\ApiService;
use Infostud\NetSuiteSdk\Exception\ApiTransferException;
use Infostud\NetSuiteSdk\Exception\ApiLogicException;
use Infostud\NetSuiteSdk\Model\Contact\ContactForm;
use Infostud\NetSuiteSdk\Model\Customer\CustomerForm;
use Infostud\NetSuiteSdk\Model\Customer\CustomerFormAddress;
use Infostud\NetSuiteSdk\Model\NotificationRecipient\NotificationRecipientForm;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderForm;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderItem;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SavedSearch\Item;
use Infostud\NetSuiteSdk\Model\SuiteQL\Classification;
use Infostud\NetSuiteSdk\Model\SuiteQL\Department;
use Infostud\NetSuiteSdk\Model\SuiteQL\Employee;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetItemsFilter;
use Infostud\NetSuiteSdk\Model\SuiteQL\Item as SuiteQLItem;
use Infostud\NetSuiteSdk\Model\SuiteQL\Location;
use Infostud\NetSuiteSdk\Model\SuiteQL\Subsidiary;
use PHPUnit\Framework\TestCase;

class ApiServiceTest extends TestCase
	{
	/**
	 * Test that it doesn't throw exceptions
	 * @return ApiService
	 * @throws ApiTransferException
	 */
	public function testParseConfig(): ApiService
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
	public function testCreateCustomer(ApiService $apiService): array
		{
		$customerForm = (new CustomerForm())
			->setExternalId('PIB-123456')
			->setCompanyName('Foo test customer')
			->setSubsidiary(getenv('SUBSIDIARY_ID'))
			->setPib('101696893')
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
	public function testCreateContact(array $params): array
		{
		/**
		 * @var $apiService ApiService
		 * @var $customerId int
		 */
		[$apiService, $customerId] = $params;
		$form = (new ContactForm())
			->setSubsidiary(getenv('SUBSIDIARY_ID'))
			->setCompany($customerId)
			->setFirstName('Little Bobby')
			->setLastName('Tables')
			->setEmail('little.bobby@tables.com')
			->setPhone('024 543839')
			->setMobilePhone('065 8717169');
		$contactId = $apiService->createContact($form);
		self::assertNotNull($contactId);

		return [
			$apiService,
			$contactId,
			$customerId
		];
		}

	/**
	 * @depends testCreateContact
	 * @param array $params
	 * @throws ApiTransferException
	 */
	public function testFindContacts(array $params): void
		{
		/**
		 * @var $apiService ApiService
		 * @var $customerId int
		 */
		[$apiService, $contactId, $customerId] = $params;
		$contacts = $apiService->findContactsByCompany($customerId);
		self::assertNotEmpty($contacts);
		$contact = $contacts[0];
		self::assertEquals($contactId, (int) $contact->getId());
		self::assertEquals('Little Bobby Tables', $contact->getAttributes()->getFullName());
		self::assertEquals('065 8717169', $contact->getAttributes()->getMobilePhone());
		self::assertEquals('little.bobby@tables.com', $contact->getAttributes()->getEmail());
		self::assertNotEmpty($contact->getAttributes()->getCompanies());
		self::assertEquals($customerId, (int) $contact->getAttributes()->getCompanies()[0]->getId());
		}

	/**
	 * @depends testCreateContact
	 * @param array $params
	 * @throws ApiTransferException
	 */
	public function testDeleteContact(array $params): void
		{
		/**
		 * @var $apiService ApiService
		 * @var $contactId int
		 */
		[$apiService, $contactId] = $params;
		self::assertTrue($apiService->deleteContact($contactId));
		}

	/**
	 * @depends testCreateCustomer
	 * @param $params array
	 * @return array
	 * @throws ApiTransferException
	 * @throws ApiLogicException
	 */
	public function testCreateNotificationRecipient(array $params): array
		{
		/**
		 * @var $apiService ApiService
		 * @var $customerId int
		 */
		[$apiService, $customerId] = $params;
		$form = (new NotificationRecipientForm())
			->setCustomer($customerId)
			->setEmailTo(['foobar@example.com'])
			->setLocations([getenv('LOCATION_ID')]);
		$recipientId = $apiService->createNotificationRecipient($form);
		self::assertNotNull($recipientId);

		return [$apiService, $recipientId];
		}

	/**
	 * @depends testCreateCustomer
	 * @param $params
	 * @throws ApiTransferException
	 */
	public function testFindNotificationRecipient(array $params): void
		{
		/**
		 * @var $apiService ApiService
		 * @var $customerId int
		 */
		[$apiService, $customerId] = $params;
		$recipients = $apiService->findNotificationRecipients($customerId, [getenv('LOCATION_ID')]);
		self::assertCount(1, $recipients);
		$recipient = $recipients[0];
		self::assertNotNull($recipient->getId());
		self::assertEquals(['foobar@example.com'], $recipient->getAttributes()->getMailTo());
		}

	/**
	 * @depends testCreateNotificationRecipient
	 * @param $params
	 * @throws ApiTransferException
	 */
	public function testDeleteNotificationRecipient(array $params): void
		{
		/**
		 * @var $apiService ApiService
		 * @var $recipientId int
		 */
		[$apiService, $recipientId] = $params;
		self::assertTrue($apiService->deleteNotificationRecipient($recipientId));
		}

	/**
	 * @depends testCreateCustomer
	 * @param array $params
	 * @return array
	 * @throws ApiTransferException
	 * @throws ApiLogicException
	 */
	public function testCreateSalesOrder(array $params): array
		{
		/**
		 * @var $apiService ApiService
		 * @var $customerId int
		 */
		[$apiService, $customerId] = $params;
		$form = (new SalesOrderForm())
			->setSubsidiary(getenv('SUBSIDIARY_ID'))
			->setDepartment(getenv('DEPARTMENT_ID'))
			->setLocation(getenv('LOCATION_ID'))
			->setClassification(getenv('CLASSIFICATION_ID'))
			->setType(SalesOrderForm::TYPE_NONE)
			->setCustomer($customerId)
			->addItem(
				(new SalesOrderItem())
					->setId(getenv('ITEM_ID'))
					->setQuantity(1)
					->setPriceAfterDiscount(5000000.00)
					->setTaxCode(8)
			)
			->setTransactionDate('02.05.2020')
			->setInvoiceImmediately(false);
			// TODO test createdBy and appointedSeller
		$salesOrderId = $apiService->createSalesOrder($form);
		self::assertNotEmpty($salesOrderId);
		return [
			$apiService,
			$salesOrderId
		];
		}

    /**
     * @depends testCreateSalesOrder
     * @param array $params
     * @return array
     */
	public function testGetSalesOrder(array $params): array
    {
        /**
         * @var $apiService ApiService
         * @var $salesOrderId int
         */
        [$apiService, $salesOrderId] = $params;
        $salesOrder = $apiService->getSalesOrder($salesOrderId);
        self::assertEquals($salesOrderId, $salesOrder->getId());
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
	public function testDeleteSalesOrder(array $param): void
		{
		/**
		 * @var ApiService $apiService
		 * @var int $salesOrderId
		 */
		[$apiService, $salesOrderId] = $param;
		$apiService->deleteSalesOrder($salesOrderId);
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testSearchByPib(ApiService $apiService): void
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
	public function testSearchByPibFragment(ApiService $apiService): void
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
	public function testSearchByRegistryIdentifier(ApiService $apiService): void
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
	public function testFindRecentItems(ApiService $apiService): void
		{
		$items = $apiService->findRecentItems(new DateTime('-1 year'));
		self::assertNotEmpty($items);
		self::assertContainsOnlyInstancesOf(Item::class, $items);
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testFindTaxItems(ApiService $apiService): void
		{
		$taxItems = $apiService->findTaxItems();
		self::assertNotEmpty($taxItems);
		foreach ($taxItems as $taxItem)
			{
			self::assertNotEmpty($taxItem->getId());
			self::assertNotEmpty($taxItem->getAttributes()->getName());
			self::assertNotEmpty($taxItem->getAttributes()->getRate());
			}
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testGetSubsidiaries(ApiService $apiService): void
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
	public function testGetDepartments(ApiService $apiService): void
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
	public function testGetLocations(ApiService $apiService): void
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
	public function testGetClassifications(ApiService $apiService): void
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
	public function testGetEmployees(ApiService $apiService): void
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
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testGetItems(ApiService $apiService): void
		{
		$itemsToTest = 100;
		$testedItems = 0;
		$items = $apiService->getItems();
		self::assertNotEmpty($items);
		foreach ($items as $item)
			{
			if ($testedItems > $itemsToTest) {
				break;
			}
			$testedItems++;
			self::assertInstanceOf(SuiteQLItem::class, $item);
			self::assertNotEmpty($item->getId());
			self::assertNotEmpty($item->getName());
			}
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 * @throws ApiTransferException
	 */
	public function testGetItemsWithFilter(ApiService $apiService): void
		{
		$itemsToTest = 100;
		$testedItems = 0;
		$items = $apiService->getItems((new GetItemsFilter())->setLocation(getenv('LOCATION_ID')));
		self::assertNotEmpty($items);
		foreach ($items as $item)
			{
			if ($testedItems > $itemsToTest) {
			break;
			}
			$testedItems++;
			self::assertInstanceOf(SuiteQLItem::class, $item);
			self::assertNotEmpty($item->getId());
			self::assertNotEmpty($item->getName());
			}
		}

	/**
	 * @depends testCreateCustomer
	 * @param array $param
	 * @throws ApiTransferException
	 */
	public function testDeleteCustomer(array $param): void
		{
		/**
		 * @var ApiService $apiService
		 * @var int $customerId
		 */
		[$apiService, $customerId] = $param;
		self::assertTrue($apiService->deleteCustomer($customerId));
		}
	}
