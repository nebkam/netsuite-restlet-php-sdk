<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

class CustomerSearchResponse
	{
	/**
	 * @var SearchMetadata
	 */
	private $myPagedData;
	/**
	 * @var Customer[]
	 */
	private $customers;

	/**
	 * @return SearchMetadata
	 */
	public function getSearchMetadata()
		{
		return $this->myPagedData;
		}

	/**
	 * @deprecated
	 * @see getSearchMetadata
	 * @return SearchMetadata
	 */
	public function getMyPagedData()
		{
		return $this->myPagedData;
		}

	/**
	 * @param SearchMetadata $myPagedData
	 * @return CustomerSearchResponse
	 */
	public function setMyPagedData($myPagedData)
		{
		$this->myPagedData = $myPagedData;

		return $this;
		}

	/**
	 * @return Customer[]
	 */
	public function getCustomers()
		{
		return $this->customers;
		}

	/**
	 * @param Customer[] $customers
	 * @return self
	 */
	public function setCustomers($customers)
		{
		$this->customers = $customers;

		return $this;
		}
	}
