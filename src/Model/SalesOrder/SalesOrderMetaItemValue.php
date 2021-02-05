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
	 * @Groups("trandate")
	 * @var string
	 */
	private $transactionDate;

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

	/**
	 * @return string
	 */
	public function getTransactionDate()
		{
		return $this->transactionDate;
		}

	/**
	 * @param string $transactionDate
	 */
	public function setTransactionDate($transactionDate)
		{
		$this->transactionDate = $transactionDate;
		}
	}
