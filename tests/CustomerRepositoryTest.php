<?php

use GuzzleHttp\Exception\GuzzleException;
use Infostud\NetSuiteSdk\ApiService;
use Infostud\NetSuiteSdk\CustomerRepository;
use PHPUnit\Framework\TestCase;

class CustomerRepositoryTest extends TestCase
	{
	/**
	 * @throws \Eher\OAuth\OAuthException
	 * @throws GuzzleException
	 */
	public function testFindOneByVatNumber()
		{
		//TODO move to config file
		$repository = new CustomerRepository(new ApiService(
			getenv('ACCOUNT'),
			getenv('CONSUMER_KEY'),
			getenv('CONSUMER_SECRET'),
			getenv('ACCESS_TOKEN_KEY'),
			getenv('ACCESS_TOKEN_SECRET')
		));
		$repository->findOneByVatNumber('109121175');
		}
	}
