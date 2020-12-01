<?php

namespace Infostud\NetSuiteSdk\Model;

class GetDepartmentsResponse implements SuiteQLResponse
	{
	/**
	 * @var Department[]
	 */
	private $rows;

	/**
	 * @return Department[]
	 */
	public function getRows(): array
		{
		return $this->rows;
		}

	/**
	 * @param Department[] $rows
	 * @return self
	 */
	public function setRows(array $rows): self
		{
		$this->rows = $rows;

		return $this;
		}
	}
