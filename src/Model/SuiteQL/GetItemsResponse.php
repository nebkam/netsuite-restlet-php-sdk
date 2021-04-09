<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

class GetItemsResponse implements SuiteQLResponse
	{
	/**
	 * @var Item[]
	 */
	private $rows;

	/**
	 * @return Item[]
	 */
	public function getRows(): array
		{
		return $this->rows;
		}

	/**
	 * @param Item[] $rows
	 * @return self
	 */
	public function setRows(array $rows): self
		{
		$this->rows = $rows;

		return $this;
		}
	}
