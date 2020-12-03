<?php

use Infostud\NetSuiteSdk\ApiService;
use Infostud\NetSuiteSdk\Model\CustomerForm;
use Infostud\NetSuiteSdk\Model\CustomerFormAddress;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SuiteQL\Department;
use Infostud\NetSuiteSdk\Model\SuiteQL\Location;
use Infostud\NetSuiteSdk\Model\SuiteQL\Subsidiary;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ApiServiceTest extends TestCase
	{
	/**
	 * Test that it doesn't throw exceptions
	 * @return ApiService
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
	 * @throws ExceptionInterface
	 */
	public function testCreateCustomer(ApiService $apiService): array
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

		return [
			$apiService,
			$customerId
		];
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
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
	 * @depends testCreateCustomer
	 * @param array $param
	 */
	public function testDeleteCustomer(array $param): void
		{
		[$apiService, $customerId] = $param;
		}
	}
