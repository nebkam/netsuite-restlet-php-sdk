<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

class GetLocationsResponse implements SuiteQLResponse
	{
	/**
	 * @var Location[]
	 */
	private $rows;

	/**
	 * @return Location[]
	 */
	public function getRows()
		{
		return $this->rows;
		}

	/**
	 * @param Location[] $rows
	 * @return self
	 */
	public function setRows($rows)
		{
		$this->rows = $rows;

		return $this;
		}
	}
