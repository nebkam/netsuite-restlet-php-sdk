<?php

namespace Infostud\NetSuiteSdk\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class CustomerSearchResponse
	{
	/**
	 * @SerializedName("myPagedData")
	 * @var SearchMetadata
	 */
	private $searchMetadata;
	/**
	 * @var Customer[]
	 */
	private $customers;

	/**
	 * @return SearchMetadata
	 */
	public function getSearchMetadata(): SearchMetadata
		{
		return $this->searchMetadata;
		}

	/**
	 * @param SearchMetadata $searchMetadata
	 * @return CustomerSearchResponse
	 */
	public function setSearchMetadata(SearchMetadata $searchMetadata): CustomerSearchResponse
		{
		$this->searchMetadata = $searchMetadata;

		return $this;
		}

	/**
	 * @return Customer[]
	 */
	public function getCustomers(): array
		{
		return $this->customers;
		}

	/**
	 * @param Customer[] $customers
	 * @return self
	 */
	public function setCustomers(array $customers): self
		{
		$this->customers = $customers;

		return $this;
		}
	}
