<?php

namespace Infostud\NetSuiteSdk\Model;

class GetSubsidiariesResponse implements SuiteQLResponse
	{
	/**
	 * @var Subsidiary[]
	 */
	private $rows;

	/**
	 * @return Subsidiary[]
	 */
	public function getRows(): array
		{
		return $this->rows;
		}

	/**
	 * @param Subsidiary[] $rows
	 * @return self
	 */
	public function setRows(array $rows): self
		{
		$this->rows = $rows;

		return $this;
		}
	}
