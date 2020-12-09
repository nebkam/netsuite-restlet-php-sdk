<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\SerializedName;

class SalesOrderItem
	{
	/**
	 * @SerializedName("item")
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
	 * @SerializedName("taxcode")
	 * @var int
	 */
	private $taxCode;

	/**
	 * @return int
	 */
	public function getId(): int
		{
		return $this->id;
		}

	/**
	 * @param int $id
	 * @return self
	 */
	public function setId(int $id): self
		{
		$this->id = $id;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getQuantity(): int
		{
		return $this->quantity;
		}

	/**
	 * @param int $quantity
	 * @return self
	 */
	public function setQuantity(int $quantity): self
		{
		$this->quantity = $quantity;

		return $this;
		}

	/**
	 * @return float
	 */
	public function getRate(): float
		{
		return $this->rate;
		}

	/**
	 * @param float $rate
	 * @return self
	 */
	public function setRate(float $rate): self
		{
		$this->rate = $rate;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getTaxCode(): int
		{
		return $this->taxCode;
		}

	/**
	 * @param int $taxCode
	 * @return self
	 */
	public function setTaxCode(int $taxCode): self
		{
		$this->taxCode = $taxCode;

		return $this;
		}
	}
