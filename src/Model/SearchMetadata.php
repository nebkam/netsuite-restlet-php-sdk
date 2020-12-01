<?php

namespace Infostud\NetSuiteSdk\Model;

class SearchMetadata
	{
	/**
	 * @var int
	 */
	private $count;
	/**
	 * @var SearchDefinition
	 */
	private $searchDefinition;

	/**
	 * @return int
	 */
	public function getCount(): int
		{
		return $this->count;
		}

	/**
	 * @param int $count
	 * @return self
	 */
	public function setCount(int $count): self
		{
		$this->count = $count;

		return $this;
		}

	/**
	 * @return SearchDefinition
	 */
	public function getSearchDefinition(): SearchDefinition
		{
		return $this->searchDefinition;
		}

	/**
	 * @param SearchDefinition $searchDefinition
	 * @return self
	 */
	public function setSearchDefinition(SearchDefinition $searchDefinition): self
		{
		$this->searchDefinition = $searchDefinition;

		return $this;
		}
	}
