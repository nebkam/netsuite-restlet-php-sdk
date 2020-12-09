<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

class GetEmployeesResponse implements SuiteQLResponse
	{
	/**
	 * @var Employee[]
	 */
	private $rows;

	/**
	 * @return Employee[]
	 */
	public function getRows(): array
		{
		return $this->rows;
		}

	/**
	 * @param Employee[] $rows
	 * @return self
	 */
	public function setRows(array $rows): self
		{
		$this->rows = $rows;

		return $this;
		}
	}
