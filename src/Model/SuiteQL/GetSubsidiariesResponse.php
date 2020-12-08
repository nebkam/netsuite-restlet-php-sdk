<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

class GetSubsidiariesResponse implements SuiteQLResponse
	{
	/**
	 * @var Subsidiary[]
	 */
	private $rows;

	/**
	 * @return Subsidiary[]
	 */
	public function getRows()
		{
		return $this->rows;
		}

	/**
	 * @param Subsidiary[] $rows
	 * @return self
	 */
	public function setRows($rows)
		{
		$this->rows = $rows;

		return $this;
		}
	}
