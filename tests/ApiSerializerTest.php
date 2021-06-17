<?php

use Infostud\NetSuiteSdk\Model\Contact\ContactForm;
use Infostud\NetSuiteSdk\Model\Contact\CreateContactResponse;
use Infostud\NetSuiteSdk\Model\Customer\CreateCustomerResponse;
use Infostud\NetSuiteSdk\Model\Customer\CustomerForm;
use Infostud\NetSuiteSdk\Model\Customer\CustomerFormAddress;
use Infostud\NetSuiteSdk\Model\Customer\DeleteCustomerResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\CreateSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\DeleteSalesOrderResponse;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderForm;
use Infostud\NetSuiteSdk\Model\SalesOrder\SalesOrderItem;
use Infostud\NetSuiteSdk\Model\SavedSearch\ColumnDefinition;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SavedSearch\CustomerSearchResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\GetOldCrmPaymentsResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\NotificationRecipient;
use Infostud\NetSuiteSdk\Model\SavedSearch\NotificationRecipientAttributes;
use Infostud\NetSuiteSdk\Model\SavedSearch\NotificationRecipientSearchResponse;
use Infostud\NetSuiteSdk\Serializer\ApiSerializer;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetDepartmentsResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\SearchDefinition;
use Infostud\NetSuiteSdk\Model\SavedSearch\SearchMetadata;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetLocationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetSubsidiariesResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\SuiteQLResponse;
use PHPUnit\Framework\TestCase;

class ApiSerializerTest extends TestCase
	{
	/**
	 * Make sure no exceptions are thrown
	 * @return ApiSerializer
	 */
	public function testInitialize()
		{
		return new ApiSerializer();
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testNormalizeCustomerFormRequest($serializer)
		{
		$customerForm = (new CustomerForm())
			->setExternalId('PIB-123456')
			->setCompanyName('Test item')
			->setSubsidiary(9)
			->setPib('101696893')
			->setRegistryIdentifier('01234567')
			->setPhone('065/871-71-69')
			->setAlternativePhone('024/843-839')
			->setUrl('https://www.4zida.rs')
			->addAddress(
				(new CustomerFormAddress())
					->setLabel('Nazor')
					->setCity('Subotica')
					->setAddressLine1('Vladimira Nazora 7')
					->setAddressLine2('(u pasažu)')
					->setPostalCode('24000')
					->setCountry(CustomerFormAddress::COUNTRY_SERBIA)
			);
		$normalized   = $serializer->normalize($customerForm);
		self::assertEquals('PIB-123456', $normalized['externalId']);
		self::assertEquals('Test item', $normalized['companyname']);
		self::assertEquals(9, $normalized['subsidiary']);
		self::assertEquals('101696893', $normalized['custentity_pib']);
		self::assertEquals('01234567', $normalized['custentity_matbrpred']);
		self::assertEquals('065/871-71-69', $normalized['phone']);
		self::assertEquals('024/843-839', $normalized['altphone']);
		self::assertEquals('https://www.4zida.rs', $normalized['url']);
		self::assertCount(1, $normalized['address']);
		$address = $normalized['address'][0];
		self::assertEquals('Nazor', $address['label']);
		self::assertEquals('Subotica', $address['city']);
		self::assertEquals('Vladimira Nazora 7', $address['addr1']);
		self::assertEquals('(u pasažu)', $address['addr2']);
		self::assertEquals('24000', $address['zip']);
		self::assertEquals(CustomerFormAddress::COUNTRY_SERBIA, $address['country']);
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testCreateCustomerResult($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/customer_create_response_success.json');
		$response = $serializer->deserialize($json, CreateCustomerResponse::class);
		self::assertInstanceOf(CreateCustomerResponse::class, $response);
		self::assertTrue($response->isSuccessful());
		self::assertEquals(41690, $response->getCustomerId());
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testDeleteCustomerResult($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/delete_customer_response_success.json');
		$response = $serializer->deserialize($json, DeleteCustomerResponse::class);
		self::assertInstanceOf(DeleteCustomerResponse::class, $response);
		self::assertTrue($response->isSuccessful());
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testNormalizeContactFormResult($serializer)
		{
		$form       = (new ContactForm())
			->setSubsidiary(getenv('SUBSIDIARY_ID'))
			->setFirstName('Little Bobby')
			->setLastName('Tables')
			->setCompany(123)
			->setMobilePhone('065/8717169');
		$normalized = $serializer->normalize($form);
		self::assertEquals('Little Bobby', $normalized['firstname']);
		self::assertEquals('Tables', $normalized['lastname']);
		self::assertEquals(123, $normalized['company']);
		self::assertEquals('065/8717169', $normalized['mobilephone']);
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testCreateContactResult($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/contact_create_response_success.json');
		$response = $serializer->deserialize($json, CreateContactResponse::class);
		/** @var CreateContactResponse $response */
		self::assertInstanceOf(CreateContactResponse::class, $response);
		self::assertTrue($response->isSuccessful());
		self::assertEquals(52198, $response->getContactId());
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testDeleteSalesOrderResult($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/delete_sales_order_response_success.json');
		$response = $serializer->deserialize($json, DeleteSalesOrderResponse::class);
		self::assertInstanceOf(DeleteSalesOrderResponse::class, $response);
		self::assertTrue($response->isSuccessful());
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testNormalizeSalesOrderFormRequest($serializer)
		{
		$form       = (new SalesOrderForm())
			->setSubsidiary(1)
			->setDepartment(2)
			->setLocation(3)
			->setClassification(4)
			->setCustomer(5)
			->setAppointedSeller(6)
			->setCreatedBy(7)
			->setInvoiceImmediately(false)
			->addItem(
				(new SalesOrderItem())
					->setId(8723)
					->setQuantity(1)
					->setPriceAfterDiscount(5000000.00)
					->setTaxCode(8)
			)
			->setTransactionDate('02.05.2020');
		$normalized = $serializer->normalize($form);
		self::assertEquals(1, $normalized['subsidiary']);
		self::assertEquals(2, $normalized['department']);
		self::assertEquals(3, $normalized['location']);
		self::assertEquals(4, $normalized['class']);
		self::assertEquals(5, $normalized['customer']);
		self::assertNotEmpty($normalized['itemArray']);
		$item = $normalized['itemArray'][0];
		self::assertEquals(8723, $item['item']);
		self::assertEquals(1, $item['quantity']);
		self::assertEquals(5000000.00, $item['rate']);
		self::assertEquals(8, $item['taxcode']);
		self::assertEquals(
			'02.05.2020',
			$normalized['trandate']
		);
		self::assertEquals(6, $normalized['custbody_rsm_infs_representative']);
		self::assertEquals(7, $normalized['custbody_rsm_infs_fakturista']);
		self::assertFalse($normalized['custbody_rsm_force_invoice']);
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testCreateSalesOrderError($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/sales_order_create_response_error.json');
		$response = $serializer->deserialize($json, CreateSalesOrderResponse::class);
		self::assertInstanceOf(CreateSalesOrderResponse::class, $response);
		/** @var CreateSalesOrderResponse $response */
		self::assertFalse($response->isSuccessful());
		self::assertEquals('INVALID_FLD_VALUE', $response->getErrorName());
		self::assertEquals(
			'The field trandate contained more than the maximum number ( 10 ) of characters allowed.',
			$response->getErrorMessage()
		);
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testSingleCustomerSearchResult($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/single_customer_search_response.json');
		$response = $serializer->deserialize($json, CustomerSearchResponse::class);
		self::assertInstanceOf(CustomerSearchResponse::class, $response);
		$searchMetadata = $response->getSearchMetadata();
		self::assertInstanceOf(SearchMetadata::class, $searchMetadata);
		self::assertEquals(1, $searchMetadata->getCount());
		$searchDefinition = $searchMetadata->getSearchDefinition();
		self::assertInstanceOf(SearchDefinition::class, $searchDefinition);
		self::assertCount(13, $searchDefinition->getColumns());
		self::assertContainsOnlyInstancesOf(ColumnDefinition::class, $searchDefinition->getColumns());
		foreach ($searchDefinition->getColumns() as $columnDefinition)
			{
			self::assertNotEmpty($columnDefinition->getName());
			self::assertNotEmpty($columnDefinition->getLabel());
			self::assertNotEmpty($columnDefinition->getType());
			self::assertNotEmpty($columnDefinition->getSortDirection());
			}

		self::assertCount(1, $response->getCustomers());
		$customer = $response->getCustomers()[0];
		self::assertInstanceOf(Customer::class, $customer);
		self::assertEquals('16099', $customer->getId());
		self::assertEquals('3DH Real Estate PR Dino Hatibović', $customer->getAttributes()->getName());
		self::assertEquals('3dhoglasavanje@gmail.com', $customer->getAttributes()->getEmail());
		self::assertEquals('109121175', $customer->getAttributes()->getPib());
		self::assertEquals('63944017', $customer->getAttributes()->getRegistryIdentifier());
		self::assertInstanceOf(DateTime::class, $customer->getAttributes()->getCreatedAt());
		self::assertEquals(
			'2020-08-07',
			$customer->getAttributes()->getCreatedAt()->format('Y-m-d')
		);
		self::assertInstanceOf(DateTime::class, $customer->getAttributes()->getLastModifiedAt());
		self::assertEquals(
			'2020-11-20',
			$customer->getAttributes()->getLastModifiedAt()->format('Y-m-d')
		);
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testNotificationRecipientSearchResponse($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/find_notification_recipients_response.json');
		$response = $serializer->deserialize($json, NotificationRecipientSearchResponse::class);
		self::assertInstanceOf(NotificationRecipientSearchResponse::class, $response);
		/** @var NotificationRecipientSearchResponse $response */
		self::assertCount(1, $response->getRows());
		$notificationRecipient = $response->getRows()[0];
		self::assertInstanceOf(NotificationRecipient::class, $notificationRecipient);
		self::assertInstanceOf(NotificationRecipientAttributes::class, $notificationRecipient->getAttributes());
		self::assertEquals(['foobar@example.com'], $notificationRecipient->getAttributes()->getMailTo());
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testGetSubsidiariesResult($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/subsidiaries_suiteql_response.json');
		$response = $serializer->deserialize($json, GetSubsidiariesResponse::class);
		self::assertInstanceOf(GetSubsidiariesResponse::class, $response);
		/** @var $response GetSubsidiariesResponse */
		self::assertSuiteQLResponse($response);
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testGetDepartmentsResult($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/departments_suiteql_response.json');
		$response = $serializer->deserialize($json, GetDepartmentsResponse::class);
		self::assertInstanceOf(GetDepartmentsResponse::class, $response);
		/** @var $response GetDepartmentsResponse */
		self::assertSuiteQLResponse($response);
		}

	/**
	 * @depends testInitialize
	 * @param $serializer ApiSerializer
	 */
	public function testGetLocationsResult($serializer)
		{
		$json     = file_get_contents(__DIR__ . '/locations_suiteql_response.json');
		$response = $serializer->deserialize($json, GetLocationsResponse::class);
		self::assertInstanceOf(GetLocationsResponse::class, $response);
		/** @var $response GetLocationsResponse */
		self::assertSuiteQLResponse($response);
		}

	/**
	 * @depends testInitialize
	 * @param ApiSerializer $serializer
	 */
	public function testGetOldCrmPaymentsResult(ApiSerializer $serializer)
		{
		$json       = file_get_contents(__DIR__ . '/get_old_crm_payments_response.json');
		/**
		 * @var GetOldCrmPaymentsResponse $response
		 */
		$response   = $serializer->deserialize($json, GetOldCrmPaymentsResponse::class);
		self::assertInstanceOf(GetOldCrmPaymentsResponse::class, $response);
		self::assertNotEmpty($response->getItems());
		self::assertSame(count($response->getItems()), 1);
		$item = $response->getItems()[0];
		self::assertSame($item->getOldCrmId(),'PO-123');
		}

	/**
	 * @param SuiteQLResponse $response
	 */
	private static function assertSuiteQLResponse($response)
		{
		self::assertNotEmpty($response->getRows());
		$ids = [];
		foreach ($response->getRows() as $item)
			{
			self::assertNotEmpty($item->getId());
			self::assertNotEmpty($item->getName());
			$ids[] = $item->getId();
			}
		// Parent consistency
		foreach ($response->getRows() as $item)
			{
			if ($item->getParentId())
				{
				self::assertContains($item->getParentId(), $ids);
				}
			}
		}
	}
