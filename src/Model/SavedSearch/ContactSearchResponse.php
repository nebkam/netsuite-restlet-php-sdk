<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

class ContactSearchResponse implements GenericSavedSearchResponse
	{
	/**
	 * @var Contact[]
	 */
	private $rows;

	/**
	 * @return Contact[]
	 */
	public function getRows(): array
		{
		return $this->rows;
		}

	/**
	 * @param Contact[] $rows
	 * @return self
	 */
	public function setRows(array $rows): self
		{
		$this->rows = $rows;

		return $this;
		}
	}
