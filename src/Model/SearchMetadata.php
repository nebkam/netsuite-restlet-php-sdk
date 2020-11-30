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
	public function getCount()
		{
		return $this->count;
		}

	/**
	 * @param int $count
	 * @return self
	 */
	public function setCount($count)
		{
		$this->count = $count;

		return $this;
		}

	/**
	 * @return SearchDefinition
	 */
	public function getSearchDefinition()
		{
		return $this->searchDefinition;
		}

	/**
	 * @param SearchDefinition $searchDefinition
	 * @return self
	 */
	public function setSearchDefinition($searchDefinition)
		{
		$this->searchDefinition = $searchDefinition;

		return $this;
		}
	}
