<?php

use Infostud\NetSuiteSdk\Model\SavedSearch\ColumnDefinition;
use Infostud\NetSuiteSdk\Model\SavedSearch\Customer;
use Infostud\NetSuiteSdk\Model\SavedSearch\CustomerSearchResponse;
use Infostud\NetSuiteSdk\ApiSerializer;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetDepartmentsResponse;
use Infostud\NetSuiteSdk\Model\SavedSearch\SearchDefinition;
use Infostud\NetSuiteSdk\Model\SavedSearch\SearchMetadata;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetLocationsResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\GetSubsidiariesResponse;
use Infostud\NetSuiteSdk\Model\SuiteQL\SuiteQLResponse;
use PHPUnit\Framework\TestCase;

class ApiSerializerTest extends TestCase
	{
	public function testSingleCustomerSearchResult()
		{
		$serializer = new ApiSerializer();
		$json = file_get_contents(__DIR__.'/single_customer_search_response.json');
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

	public function testGetSubsidiariesResult()
		{
		$serializer = new ApiSerializer();
		$json = file_get_contents(__DIR__.'/subsidiaries_suiteql_response.json');
		$response = $serializer->deserialize($json, GetSubsidiariesResponse::class);
		self::assertInstanceOf(GetSubsidiariesResponse::class, $response);
		self::assertSuiteQLResponse($response);
		}

	public function testGetDepartmentsResult()
		{
		$serializer = new ApiSerializer();
		$json = file_get_contents(__DIR__.'/departments_suiteql_response.json');
		$response = $serializer->deserialize($json, GetDepartmentsResponse::class);
		self::assertInstanceOf(GetDepartmentsResponse::class, $response);
		self::assertSuiteQLResponse($response);
		}

	public function testGetLocationsResult()
		{
		$serializer = new ApiSerializer();
		$json = file_get_contents(__DIR__.'/locations_suiteql_response.json');
		$response = $serializer->deserialize($json, GetLocationsResponse::class);
		self::assertInstanceOf(GetLocationsResponse::class, $response);
		self::assertSuiteQLResponse($response);
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
