<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

class GetDepartmentsResponse implements SuiteQLResponse
	{
	/**
	 * @var Department[]
	 */
	private $rows;

	/**
	 * @return Department[]
	 */
	public function getDepartments()
		{
		return $this->rows;
		}

	/**
	 * @deprecated
	 * @see getDepartments
	 * @return Department[]
	 */
	public function getRows()
		{
		return $this->rows;
		}

	/**
	 * @param Department[] $rows
	 * @return self
	 */
	public function setRows($rows)
		{
		$this->rows = $rows;

		return $this;
		}
	}
