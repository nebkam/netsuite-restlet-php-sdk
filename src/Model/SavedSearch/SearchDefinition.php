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
	public function getColumns()
		{
		return $this->columns;
		}

	/**
	 * @param ColumnDefinition[] $columns
	 * @return self
	 */
	public function setColumns($columns)
		{
		$this->columns = $columns;

		return $this;
		}
	}
