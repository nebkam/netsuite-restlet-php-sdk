<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use DateTime;
use Symfony\Component\Serializer\Annotation\SerializedName;

class SalesOrderForm
	{
	/**
	 * @var int
	 */
	private $subsidiary;
	/**
	 * @var int
	 */
	private $department;
	/**
	 * @var int
	 */
	private $location;
	/**
	 * @SerializedName("class")
	 * @var int
	 */
	private $classification;
	/**
	 * @var int
	 */
	private $customer;
	/**
	 * @SerializedName("itemArray")
	 * @var SalesOrderItem[]
	 */
	private $items;
	/**
	 * @SerializedName("trandate")
	 * @var DateTime
	 */
	private $transactionDate;

	public function __construct()
		{
		$this->items = [];
		}

	/**
	 * @return int
	 */
	public function getSubsidiary(): int
		{
		return $this->subsidiary;
		}

	/**
	 * @param int $subsidiary
	 * @return self
	 */
	public function setSubsidiary(int $subsidiary): self
		{
		$this->subsidiary = $subsidiary;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getDepartment(): int
		{
		return $this->department;
		}

	/**
	 * @param int $department
	 * @return self
	 */
	public function setDepartment(int $department): self
		{
		$this->department = $department;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getLocation(): int
		{
		return $this->location;
		}

	/**
	 * @param int $location
	 * @return self
	 */
	public function setLocation(int $location): self
		{
		$this->location = $location;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getClassification(): int
		{
		return $this->classification;
		}

	/**
	 * @param int $classification
	 * @return self
	 */
	public function setClassification(int $classification): self
		{
		$this->classification = $classification;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getCustomer(): int
		{
		return $this->customer;
		}

	/**
	 * @param int $customer
	 * @return self
	 */
	public function setCustomer(int $customer): self
		{
		$this->customer = $customer;

		return $this;
		}

	/**
	 * @return SalesOrderItem[]
	 */
	public function getItems(): array
		{
		return $this->items;
		}

	/**
	 * @param SalesOrderItem[] $items
	 * @return self
	 */
	public function setItems(array $items): self
		{
		$this->items = $items;

		return $this;
		}

	/**
	 * @param SalesOrderItem $item
	 * @return self
	 */
	public function addItem(SalesOrderItem $item): self
		{
		$this->items[] = $item;

		return $this;
		}

	/**
	 * @return self
	 */
	public function clearItems(): self
		{
		$this->items = [];

		return $this;
		}

	/**
	 * @return DateTime
	 */
	public function getTransactionDate(): DateTime
		{
		return $this->transactionDate;
		}

	/**
	 * @param DateTime $transactionDate
	 * @return self
	 */
	public function setTransactionDate(DateTime $transactionDate): self
		{
		$this->transactionDate = $transactionDate;

		return $this;
		}
	}
