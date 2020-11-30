<?php

namespace Infostud\NetSuiteSdk;

use Eher\OAuth\OAuthException;
use GuzzleHttp\Exception\GuzzleException;

class CustomerRepository
	{
	/**
	 * @var ApiService
	 */
	private $apiService;

	/**
	 * @param ApiService $apiService
	 */
	public function __construct($apiService)
		{
		$this->apiService = $apiService;
		}

	/**
	 * @param string $vatNumber
	 * @throws OAuthException
	 * @throws GuzzleException
	 */
	public function findOneByVatNumber($vatNumber)
		{
		$filters = [[
			'name' => 'custentity_pib',
			'operator' => 'is',
			'values' => [$vatNumber]
		]];
		$results = $this->apiService->customerSearch($filters);
		// TODO not found
		// TODO not unique
		// TODO return customer
		}
	}
