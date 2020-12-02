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
	public function getRows(): array
		{
		return $this->rows;
		}

	/**
	 * @param Location[] $rows
	 * @return self
	 */
	public function setRows(array $rows): self
		{
		$this->rows = $rows;

		return $this;
		}
	}
