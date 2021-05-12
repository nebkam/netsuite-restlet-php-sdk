<?php

use Infostud\NetSuiteSdk\ApiConfig;
use Infostud\NetSuiteSdk\ApiSerializer;
use Infostud\NetSuiteSdk\Exception\ApiTransferException;

class ApiConfigTest extends PHPUnit_Framework_TestCase
	{
	/**
	 * @throws ApiTransferException
	 */
	public function testFromJson(): void
		{
		$path = __DIR__.'/test.config.json';
		$serializer = new ApiSerializer();
		$config = ApiConfig::fromJsonFile($path, $serializer);
		$this->assertEquals('123_SB1', $config->getRealm());
		$this->assertEquals('123-sb1', $config->getRestletUrlFragment());
		}
	}
