<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\Groups;

class SalesOrderItem
	{
	/**
	 * @Groups("item")
	 * @var int
	 */
	private $id;
	/**
	 * @var int
	 */
	private $quantity;
	/**
	 * @var float
	 */
	private $rate;
	/**
	 * @Groups("taxcode")
	 * @var int
	 */
	private $taxCode;

	/**
	 * @return int
	 */
	public function getId()
		{
		return $this->id;
		}

	/**
	 * @param int $id
	 * @return self
	 */
	public function setId($id)
		{
		$this->id = $id;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getQuantity()
		{
		return $this->quantity;
		}

	/**
	 * @param int $quantity
	 * @return self
	 */
	public function setQuantity($quantity)
		{
		$this->quantity = $quantity;

		return $this;
		}

	/**
	 * @return float
	 */
	public function getRate()
		{
		return $this->rate;
		}

	/**
	 * @param float $rate
	 * @return self
	 */
	public function setRate($rate)
		{
		$this->rate = $rate;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getTaxCode()
		{
		return $this->taxCode;
		}

	/**
	 * @param int $taxCode
	 * @return self
	 */
	public function setTaxCode($taxCode)
		{
		$this->taxCode = $taxCode;

		return $this;
		}
	}
