<?php


namespace Infostud\NetSuiteSdk\Model\SavedSearch;


use Symfony\Component\Serializer\Annotation\SerializedName;

class OldCrmPaymentItem
	{
	/**
	 * @SerializedName("recordType")
	 * @var string
	 */
	private $recordType;

	/**
	 * @SerializedName("lastmodifieddate")
	 * @var string
	 */
	private $lastModifiedDate;

	/**
	 * @SerializedName("trandate")
	 * @var string
	 */
	private $transactionDate;

	/**
	 * @SerializedName("customer")
	 * @var string
	 */
	private $customerId;

	/**
	 * @SerializedName("line")
	 * @var string
	 */
	private $line;

	/**
	 * @SerializedName("tranid")
	 * @var string
	 */
	private $transactionId;

	/**
	 * @SerializedName("amount")
	 * @var string
	 */
	private $amount;

	/**
	 * @SerializedName("invoice_old_crm_id")
	 * @var string
	 */
	private $oldCrmId;

	/**
	 * @SerializedName("appliedtotransaction")
	 * @var string
	 */
	private $appliedTransactionName;

	/**
	 * @return string
	 */
	public function getRecordType(): string
		{
		return $this->recordType;
		}

	/**
	 * @param string $recordType
	 * @return OldCrmPaymentItem
	 */
	public function setRecordType(string $recordType): OldCrmPaymentItem
		{
		$this->recordType = $recordType;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getLastModifiedDate(): string
		{
		return $this->lastModifiedDate;
		}

	/**
	 * @param string $lastModifiedDate
	 * @return OldCrmPaymentItem
	 */
	public function setLastModifiedDate(string $lastModifiedDate): OldCrmPaymentItem
		{
		$this->lastModifiedDate = $lastModifiedDate;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getTransactionDate(): string
		{
		return $this->transactionDate;
		}

	/**
	 * @param string $transactionDate
	 * @return OldCrmPaymentItem
	 */
	public function setTransactionDate(string $transactionDate): OldCrmPaymentItem
		{
		$this->transactionDate = $transactionDate;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getCustomerId(): string
		{
		return $this->customerId;
		}

	/**
	 * @param string $customerId
	 * @return OldCrmPaymentItem
	 */
	public function setCustomerId(string $customerId): OldCrmPaymentItem
		{
		$this->customerId = $customerId;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getLine(): string
		{
		return $this->line;
		}

	/**
	 * @param string $line
	 * @return OldCrmPaymentItem
	 */
	public function setLine(string $line): OldCrmPaymentItem
		{
		$this->line = $line;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getTransactionId(): string
		{
		return $this->transactionId;
		}

	/**
	 * @param string $transactionId
	 * @return OldCrmPaymentItem
	 */
	public function setTransactionId(string $transactionId): OldCrmPaymentItem
		{
		$this->transactionId = $transactionId;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getAmount(): string
		{
		return $this->amount;
		}

	/**
	 * @param string $amount
	 * @return OldCrmPaymentItem
	 */
	public function setAmount(string $amount): OldCrmPaymentItem
		{
		$this->amount = $amount;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getOldCrmId(): string
		{
		return $this->oldCrmId;
		}

	/**
	 * @param string $oldCrmId
	 * @return OldCrmPaymentItem
	 */
	public function setOldCrmId(string $oldCrmId): OldCrmPaymentItem
		{
		$this->oldCrmId = $oldCrmId;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getAppliedTransactionName(): string
		{
		return $this->appliedTransactionName;
		}

	/**
	 * @param string $appliedTransactionName
	 * @return OldCrmPaymentItem
	 */
	public function setAppliedTransactionName(string $appliedTransactionName): OldCrmPaymentItem
		{
		$this->appliedTransactionName = $appliedTransactionName;

		return $this;
		}


	}
