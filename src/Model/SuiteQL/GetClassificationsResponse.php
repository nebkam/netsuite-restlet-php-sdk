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
	public function getRows(): array
		{
		return $this->rows;
		}

	/**
	 * @param Classification[] $rows
	 * @return self
	 */
	public function setRows(array $rows): self
		{
		$this->rows = $rows;

		return $this;
		}
	}
