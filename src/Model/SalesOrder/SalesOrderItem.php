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
	 * @Groups("custcol_rsm_item_rate_full")
	 * @var float
	 */
	private $priceBeforeDiscount;
	/**
	 * @Groups("custcol_rsm_item_rate_discount")
	 * @var int
	 */
	private $discount;
	/**
	 * @Groups("rate")
	 * @var float
	 */
	private $priceAfterDiscount;
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

	/**
	 * @return float
	 */
	public function getPriceBeforeDiscount()
		{
		return $this->priceBeforeDiscount;
		}

	/**
	 * @param float $priceBeforeDiscount
	 */
	public function setPriceBeforeDiscount($priceBeforeDiscount)
		{
		$this->priceBeforeDiscount = $priceBeforeDiscount;
		}

	/**
	 * @return int
	 */
	public function getDiscount()
		{
		return $this->discount;
		}

	/**
	 * @param int $discount
	 */
	public function setDiscount($discount)
		{
		$this->discount = $discount;
		}

	/**
	 * @return float
	 */
	public function getPriceAfterDiscount()
		{
		return $this->priceAfterDiscount;
		}

	/**
	 * @param float $priceAfterDiscount
	 */
	public function setPriceAfterDiscount($priceAfterDiscount)
		{
		$this->priceAfterDiscount = $priceAfterDiscount;
		}
	}
