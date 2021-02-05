<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\Groups;

class SalesOrderDataResponse
	{
	/**
	 * @Groups("orderdata")
	 * @var SalesOrderMetaItem[]
	 */
	private $rows;

	/**
	 * @return SalesOrderMetaItem[]
	 */
	public function getRows()
		{
		return $this->rows;
		}

	/**
	 * @param SalesOrderMetaItem[] $rows
	 */
	public function setRows($rows)
		{
		$this->rows = $rows;
		}
	}
