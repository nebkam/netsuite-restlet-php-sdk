<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

class SearchDefinition
	{
	/**
	 * @var ColumnDefinition[]
	 */
	private $columns;

	/**
	 * @return ColumnDefinition[]
	 */
	public function getColumns(): array
		{
		return $this->columns;
		}

	/**
	 * @param ColumnDefinition[] $columns
	 * @return self
	 */
	public function setColumns(array $columns): self
		{
		$this->columns = $columns;

		return $this;
		}
	}
