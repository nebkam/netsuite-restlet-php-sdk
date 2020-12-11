<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

class TaxItemSearchResponse implements GenericSavedSearchResponse
	{
	/**
	 * @var TaxItem[]
	 */
	private $rows;

	/**
	 * @return TaxItem[]
	 */
	public function getRows(): array
		{
		return $this->rows;
		}

	/**
	 * @param TaxItem[] $rows
	 * @return self
	 */
	public function setRows(array $rows): self
		{
		$this->rows = $rows;

		return $this;
		}
	}
