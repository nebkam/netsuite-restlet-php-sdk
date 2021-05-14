<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class PaymentItem
	{
	/**
	 * @var string
	 */
	private $recordType;

	/**
	 * @Groups("lastmodifieddate")
	 * @var string
	 */
	private $lastModifiedDate;

	/**
	 * @Groups("trandate")
	 * @var string
	 */
	private $transactionDate;

	/**
	 * @Groups("customer")
	 * @var string
	 */
	private $customerId;

	/**
	 * @var string
	 */
	private $line;

	/**
	 * @Groups("tranid")
	 * @var string
	 */
	private $transactionId;

	/**
	 * @var string
	 */
	private $amount;

	/**
	 * @Groups("salesorder")
	 * @var string
	 */
	private $salesOrder;

	/**
	 * @Groups("appliedtotransaction")
	 * @var string
	 */
	private $appliedTransactionName;

	/**
	 * @return string
	 */
	public function getRecordType()
		{
		return $this->recordType;
		}

	/**
	 * @param string $recordType
	 *
	 * @return PaymentItem
	 */
	public function setRecordType($recordType)
		{
		$this->recordType = $recordType;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getLastModifiedDate()
		{
		return $this->lastModifiedDate;
		}

	/**
	 * @param string $lastModifiedDate
	 *
	 * @return PaymentItem
	 */
	public function setLastModifiedDate($lastModifiedDate)
		{
		$this->lastModifiedDate = $lastModifiedDate;

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
	 * @param string $transactionDate
	 *
	 * @return PaymentItem
	 */
	public function setTransactionDate($transactionDate)
		{
		$this->transactionDate = $transactionDate;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getCustomerId()
		{
		return $this->customerId;
		}

	/**
	 * @param string $customerId
	 *
	 * @return PaymentItem
	 */
	public function setCustomerId($customerId)
		{
		$this->customerId = $customerId;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getLine()
		{
		return $this->line;
		}

	/**
	 * @param string $line
	 *
	 * @return PaymentItem
	 */
	public function setLine($line)
		{
		$this->line = $line;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getTransactionId()
		{
		return $this->transactionId;
		}

	/**
	 * @param string $transactionId
	 *
	 * @return PaymentItem
	 */
	public function setTransactionId($transactionId)
		{
		$this->transactionId = $transactionId;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getAmount()
		{
		return $this->amount;
		}

	/**
	 * @param string $amount
	 *
	 * @return PaymentItem
	 */
	public function setAmount($amount)
		{
		$this->amount = $amount;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getSalesOrder()
		{
		return $this->salesOrder;
		}

	/**
	 * @param string $salesOrder
	 *
	 * @return PaymentItem
	 */
	public function setSalesOrder($salesOrder)
		{
		$this->salesOrder = $salesOrder;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getAppliedTransactionName()
		{
		return $this->appliedTransactionName;
		}

	/**
	 * @param string $appliedTransactionName
	 *
	 * @return PaymentItem
	 */
	public function setAppliedTransactionName($appliedTransactionName)
		{
		$this->appliedTransactionName = $appliedTransactionName;

		return $this;
		}
	}
