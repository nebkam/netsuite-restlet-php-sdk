<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class TaxItemSearchResponse
	{
	/**
	 * @var TaxItem[]
	 */
	private $rows;

	/**
	 * @return TaxItem[]
	 */
	public function getRows()
		{
		return $this->rows;
		}

	/**
	 * @param TaxItem[] $rows
	 * @return self
	 */
	public function setRows($rows)
		{
		$this->rows = $rows;

		return $this;
		}
	}