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
	public function getRows()
		{
		return $this->rows;
		}

	/**
	 * @param Employee[] $rows
	 * @return self
	 */
	public function setRows($rows)
		{
		$this->rows = $rows;

		return $this;
		}
	}
