<?php

use Infostud\NetSuiteSdk\ApiService;
use Infostud\NetSuiteSdk\Model\Customer;
use Infostud\NetSuiteSdk\Model\Department;
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
	 */
	public function testSearchByPibFragment($apiService)
		{
		self::markTestSkipped();
		$customer = $apiService->findCustomerByPibFragment('si49380290');
		self::assertInstanceOf(Customer::class, $customer);
		self::assertEquals('si49380290', $customer->getAttributes()->getPib());
		}

	/**
	 * TODO Add real JMBG
	 * @depends testParseConfig
	 * @param ApiService $apiService
	 */
	public function testSearchByRegistryIdentifier($apiService)
		{
		self::markTestSkipped();
		$customer = $apiService->findCustomerByRegistryIdentifier('209970780048');
		self::assertInstanceOf(Customer::class, $customer);
		self::assertEquals('209970780048', $customer->getAttributes()->getRegistryIdentifier());
		}

	/**
	 * @depends testParseConfig
	 * @param ApiService $apiService
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
	}
