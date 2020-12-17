<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\Groups;

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
	 * @Groups("class")
	 * @var int
	 */
	private $classification;
	/**
	 * @var int
	 */
	private $customer;
	/**
	 * @Groups("itemArray")
	 * @var SalesOrderItem[]
	 */
	private $items;
	/**
	 * @Groups("trandate")
	 * @var string
	 */
	private $transactionDate;
	/**
	 * @Groups("custbody_rsm_infs_fakturista")
	 * @var int|null
	 */
	private $createdBy;
	/**
	 * @Groups("custbody_rsm_infs_representative")
	 * @var int|null
	 */
	private $appointedSeller;
	/**
	 * @Groups("custbody_rsm_force_invoice")
	 * @var bool|null
	 */
	private $invoiceImmediately;
	/**
	 * @var string|null
	 */
	private $memo;
	/**
	 * @Groups("startdate")
	 * @var string|null
	 */
	private $startDate;
	/**
	 * @Groups("enddate")
	 * @var string|null
	 */
	private $endDate;

	public function __construct()
		{
		$this->items = [];
		}

	/**
	 * @return int
	 */
	public function getSubsidiary()
		{
		return $this->subsidiary;
		}

	/**
	 * @param int $subsidiary
	 * @return self
	 */
	public function setSubsidiary($subsidiary)
		{
		$this->subsidiary = $subsidiary;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getDepartment()
		{
		return $this->department;
		}

	/**
	 * @param int $department
	 * @return self
	 */
	public function setDepartment($department)
		{
		$this->department = $department;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getLocation()
		{
		return $this->location;
		}

	/**
	 * @param int $location
	 * @return self
	 */
	public function setLocation($location)
		{
		$this->location = $location;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getClassification()
		{
		return $this->classification;
		}

	/**
	 * @param int $classification
	 * @return self
	 */
	public function setClassification($classification)
		{
		$this->classification = $classification;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getCustomer()
		{
		return $this->customer;
		}

	/**
	 * @param int $customer
	 * @return self
	 */
	public function setCustomer($customer)
		{
		$this->customer = $customer;

		return $this;
		}

	/**
	 * @return SalesOrderItem[]
	 */
	public function getItems()
		{
		return $this->items;
		}

	/**
	 * @param SalesOrderItem[] $items
	 * @return self
	 */
	public function setItems(array $items)
		{
		$this->items = $items;

		return $this;
		}

	/**
	 * @param SalesOrderItem $item
	 * @return self
	 */
	public function addItem(SalesOrderItem $item)
		{
		$this->items[] = $item;

		return $this;
		}

	/**
	 * @return self
	 */
	public function clearItems()
		{
		$this->items = [];

		return $this;
		}

	/**
	 * @return string
	 */
	public function getTransactionDate()
		{
		return $this->transactionDate;
		}

	/**
	 * Transaction date in "d.m.Y" format
	 * @param string $transactionDate
	 * @return self
	 * @example "02.05.2020"
	 *
	 * Unfortunately, PHP doesn't have a native `Date` type
	 * so we're passing string "as-is" to the API
	 *
	 */
	public function setTransactionDate($transactionDate)
		{
		$this->transactionDate = $transactionDate;

		return $this;
		}

	/**
	 * @return int|null
	 */
	public function getCreatedBy()
		{
		return $this->createdBy;
		}

	/**
	 * @param int|null $id
	 * @return self
	 */
	public function setCreatedBy($id)
		{
		$this->createdBy = $id;

		return $this;
		}

	/**
	 * @return int|null
	 */
	public function getAppointedSeller()
		{
		return $this->appointedSeller;
		}

	/**
	 * @param int|null $id
	 * @return self
	 */
	public function setAppointedSeller($id)
		{
		$this->appointedSeller = $id;

		return $this;
		}

	/**
	 * @return bool|null
	 */
	public function getInvoiceImmediately()
		{
		return $this->invoiceImmediately;
		}

	/**
	 * @param bool|null $value
	 * @return self
	 */
	public function setInvoiceImmediately($value)
		{
		$this->invoiceImmediately = $value;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getMemo()
		{
		return $this->memo;
		}

	/**
	 * @param string|null $memo
	 * @return self
	 */
	public function setMemo($memo)
		{
		$this->memo = $memo;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getStartDate()
		{
		return $this->startDate;
		}

	/**
	 * Start date in "d.m.Y" format
	 * @param string|null $startDate
	 * @return self
	 * @example "02.05.2020"
	 *
	 * Unfortunately, PHP doesn't have a native `Date` type
	 * so we're passing string "as-is" to the API
	 *
	 */
	public function setStartDate($startDate)
		{
		$this->startDate = $startDate;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getEndDate()
		{
		return $this->endDate;
		}

	/**
	 * End date in "d.m.Y" format
	 * @param string|null $endDate
	 * @return self
	 * @example "02.05.2020"
	 *
	 * Unfortunately, PHP doesn't have a native `Date` type
	 * so we're passing string "as-is" to the API
	 *
	 */
	public function setEndDate($endDate)
		{
		$this->endDate = $endDate;

		return $this;
		}
	}
