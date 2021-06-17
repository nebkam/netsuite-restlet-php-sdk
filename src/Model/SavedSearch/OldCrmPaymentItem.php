<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class OldCrmPaymentItem
	{
	/**
	 * @Groups("recordType")
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
	 * @Groups("line")
	 * @var string
	 */
	private $line;

	/**
	 * @Groups("tranid")
	 * @var string
	 */
	private $transactionId;

	/**
	 * @Groups("amount")
	 * @var string
	 */
	private $amount;

	/**
	 * @Groups("invoice_old_crm_id")
	 * @var string
	 */
	private $oldCrmId;

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
	 * @return self
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
	 * @return self
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
	 * @return OldCrmPaymentItem
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
	 * @return self
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
	 * @return self
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
	 * @return self
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
	 * @return self
	 */
	public function setAmount($amount)
		{
		$this->amount = $amount;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getOldCrmId()
		{
		return $this->oldCrmId;
		}

	/**
	 * @param string $oldCrmId
	 * @return self
	 */
	public function setOldCrmId($oldCrmId)
		{
		$this->oldCrmId = $oldCrmId;

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
	 * @return self
	 */
	public function setAppliedTransactionName($appliedTransactionName)
		{
		$this->appliedTransactionName = $appliedTransactionName;

		return $this;
		}
	}
