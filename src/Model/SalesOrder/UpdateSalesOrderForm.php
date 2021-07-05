<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\SerializedName;

class UpdateSalesOrderForm
	{
	/**
	 * @SerializedName("startdate")
	 * @var string|null
	 */
	private $startDate;
	/**
	 * @SerializedName("enddate")
	 * @var string|null
	 */
	private $endDate;

	/**
	 * @return string|null
	 */
	public function getStartDate(): ?string
		{
		return $this->startDate;
		}

	/**
	 * @param string|null $startDate
	 * @return UpdateSalesOrderForm
	 */
	public function setStartDate(?string $startDate): UpdateSalesOrderForm
		{
		$this->startDate = $startDate;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getEndDate(): ?string
		{
		return $this->endDate;
		}

	/**
	 * @param string|null $endDate
	 * @return UpdateSalesOrderForm
	 */
	public function setEndDate(?string $endDate): UpdateSalesOrderForm
		{
		$this->endDate = $endDate;

		return $this;
		}

	}
