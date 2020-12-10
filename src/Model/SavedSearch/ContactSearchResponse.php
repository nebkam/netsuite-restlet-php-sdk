<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class ContactSearchResponse
	{
	/**
	 * @var Contact[]
	 */
	private $rows;

	/**
	 * @return Contact[]
	 */
	public function getRows()
		{
		return $this->rows;
		}

	/**
	 * @param Contact[] $rows
	 * @return self
	 */
	public function setRows($rows)
		{
		$this->rows = $rows;

		return $this;
		}
	}