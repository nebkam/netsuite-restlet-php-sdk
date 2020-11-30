<?php

use Infostud\NetSuiteSdk\ApiService;
use Infostud\NetSuiteSdk\Model\Customer;
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
	public function testSearchByVatIdentifier($apiService)
		{
		$customer = $apiService->findCustomerByVatIdentifier('109121175');
		self::assertInstanceOf(Customer::class, $customer);
		self::assertEquals('109121175', $customer->getAttributes()->getVatIdentifier());
		self::assertInstanceOf(DateTime::class, $customer->getAttributes()->getCreatedAt());
		self::assertInstanceOf(DateTime::class, $customer->getAttributes()->getLastModifiedAt());
		}
	}
