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
	 * @SerializedName("custcol_rsm_item_rate_full")
	 * @var float
	 */
	private $priceBeforeDiscount;
	/**
	 * @SerializedName("custcol_rsm_item_rate_discount")
	 * @var int
	 */
	private $discount;
	/**
	 * @SerializedName("rate")
	 * @var float
	 */
	private $priceAfterDiscount;
	/**
	 * @SerializedName("taxcode")
	 * @var int|null
	 */
	private $taxCode;
	/**
	 * This is only used by Poslovi
	 *
	 * @SerializedName("custcol_rsm_package_quantity")
	 * @var int|null
	 */
	private $posloviJobPackageQuantity;

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

	public function getPriceBeforeDiscount(): ?float
		{
		return $this->priceBeforeDiscount;
		}

	public function setPriceBeforeDiscount(?float $priceBeforeDiscount): self
		{
		$this->priceBeforeDiscount = $priceBeforeDiscount;

		return $this;
		}

	public function getDiscount(): ?int
		{
		return $this->discount;
		}

	public function setDiscount(?int $discount): self
		{
		$this->discount = $discount;

		return $this;
		}

	public function getPriceAfterDiscount(): ?float
		{
		return $this->priceAfterDiscount;
		}

	public function setPriceAfterDiscount(?float $priceAfterDiscount): self
		{
		$this->priceAfterDiscount = $priceAfterDiscount;

		return $this;
		}

	/**
	 * @return int|null
	 */
	public function getTaxCode(): ?int
		{
		return $this->taxCode;
		}

	/**
	 * @param int|null $taxCode
	 * @return self
	 */
	public function setTaxCode(?int $taxCode): self
		{
		$this->taxCode = $taxCode;

		return $this;
		}

	/**
	 * @return int|null
	 */
	public function getPosloviJobPackageQuantity(): ?int
		{
		return $this->posloviJobPackageQuantity;
		}

	/**
	 * @param int|null $posloviJobPackageQuantity
	 * @return SalesOrderItem
	 */
	public function setPosloviJobPackageQuantity(?int $posloviJobPackageQuantity): self
		{
		$this->posloviJobPackageQuantity = $posloviJobPackageQuantity;

		return $this;
		}

	}
