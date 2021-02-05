<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\Groups;
use Infostud\NetSuiteSdk\Model\SavedSearch\IdNameTuple;

class SalesOrderMetaItemValue
	{
	/**
	 * @Groups("custbody_cust_dep_pdf_file")
	 * @var IdNameTuple[]
	 */
	private $pdf;

	/**
	 * @return IdNameTuple[]
	 */
	public function getPdf()
		{
		return $this->pdf;
		}

	/**
	 * @param IdNameTuple[] $pdf
	 */
	public function setPdf($pdf)
		{
		$this->pdf = $pdf;
		}
	}
