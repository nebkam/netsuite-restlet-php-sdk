<?php

use Infostud\NetSuiteSdk\Model\ColumnDefinition;
use Infostud\NetSuiteSdk\Model\Customer;
use Infostud\NetSuiteSdk\Model\GetSubsidiariesResponse;
use Infostud\NetSuiteSdk\Model\SavedSearchCustomersResponse;
use Infostud\NetSuiteSdk\ApiSerializer;
use Infostud\NetSuiteSdk\Model\GetDepartmentsResponse;
use PHPUnit\Framework\TestCase;

class ApiSerializerTest extends TestCase
	{
	public function testSingleCustomerSearchResult(): void
		{
		$serializer = new ApiSerializer();
		$json = file_get_contents(__DIR__.'/single_customer_search_response.json');
		$response = $serializer->deserialize($json, SavedSearchCustomersResponse::class);
		self::assertInstanceOf(SavedSearchCustomersResponse::class, $response);
		$searchMetadata = $response->getSearchMetadata();
		self::assertEquals(1, $searchMetadata->getCount());
		$searchDefinition = $searchMetadata->getSearchDefinition();
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
		self::assertEquals('109121175', $customer->getAttributes()->getVatIdentifier());
		self::assertEquals('63944017', $customer->getAttributes()->getRegistryIdentifier());
		self::assertEquals(
			'2020-08-07T11:36:00+02:00',
			$customer->getAttributes()->getCreatedAt()->format(DateTimeInterface::ATOM)
		);
		self::assertEquals(
			'2020-11-20T11:55:00+01:00',
			$customer->getAttributes()->getLastModifiedAt()->format(DateTimeInterface::ATOM)
		);
		}

	public function testGetSubsidiariesResult(): void
		{
		$serializer = new ApiSerializer();
		$json = file_get_contents(__DIR__.'/subsidiaries_suiteql_response.json');
		$response = $serializer->deserialize($json, GetSubsidiariesResponse::class);
		self::assertInstanceOf(GetSubsidiariesResponse::class, $response);
		self::assertNotEmpty($response->getSubsidiaries());
		$subsidiaryIds = [];
		foreach ($response->getSubsidiaries() as $subsidiary)
			{
			self::assertNotEmpty($subsidiary->getId());
			self::assertNotEmpty($subsidiary->getName());
			$subsidiaryIds[] = $subsidiary->getId();
			}
		// Parent consistency
		foreach ($response->getSubsidiaries() as $subsidiary)
			{
			if ($subsidiary->getParentId())
				{
				self::assertContains($subsidiary->getParentId(), $subsidiaryIds);
				}
			}
		}

	public function testGetDepartmentsResult(): void
		{
		$serializer = new ApiSerializer();
		$json = file_get_contents(__DIR__.'/departments_suiteql_response.json');
		$response = $serializer->deserialize($json, GetDepartmentsResponse::class);
		self::assertInstanceOf(GetDepartmentsResponse::class, $response);
		self::assertNotEmpty($response->getDepartments());
		$departmentIds = [];
		foreach ($response->getDepartments() as $department)
			{
			self::assertNotEmpty($department->getId());
			self::assertNotEmpty($department->getName());
			$departmentIds[] = $department->getId();
			}
		// Parent consistency
		foreach ($response->getDepartments() as $department)
			{
			if ($department->getParentId())
				{
				self::assertContains($department->getParentId(), $departmentIds);
				}
			}
		}
	}
