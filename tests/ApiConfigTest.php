<?php

use Infostud\NetSuiteSdk\ApiConfig;
use Infostud\NetSuiteSdk\ApiSerializer;
use Infostud\NetSuiteSdk\Exception\ApiTransferException;
use Infostud\NetSuiteSdk\Restlet;
use Infostud\NetSuiteSdk\RestletMap;

/**
 * @group production
 */
class ApiConfigTest extends PHPUnit_Framework_TestCase
	{
	/**
	 * @throws ApiTransferException
	 */
	public function testFromJsonFile(): ApiConfig
		{
		$path = __DIR__.'/test.config.json';
		$serializer = new ApiSerializer();
		return ApiConfig::fromJsonFile($path, $serializer);
		}

	/**
	 * @depends testFromJsonFile
	 * @param ApiConfig $config
	 */
	public function testAccountId(ApiConfig $config): void
		{
		$this->assertEquals('123_SB1', $config->getRealm());
		$this->assertEquals('123-sb1', $config->getRestletUrlFragment());
		}

	/**
	 * @depends testFromJsonFile
	 * @param ApiConfig $config
	 */
	public function testRestletMap(ApiConfig $config): void
		{
		$this->assertInstanceOf(RestletMap::class, $config->restletMap);
		$this->assertInstanceOf(Restlet::class, $config->restletMap->createDeleteCustomer);
		$this->assertEquals(123, $config->restletMap->createDeleteCustomer->script);
		$this->assertEquals(3, $config->restletMap->createDeleteCustomer->deploy);
		}
	}
