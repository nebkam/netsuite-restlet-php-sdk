<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

class GetClassificationsResponse implements SuiteQLResponse
	{
	/**
	 * @var Classification[]
	 */
	private $rows;

	/**
	 * @return Classification[]
	 */
	public function getRows()
		{
		return $this->rows;
		}

	/**
	 * @param Classification[] $rows
	 * @return self
	 */
	public function setRows($rows)
		{
		$this->rows = $rows;

		return $this;
		}
	}
