<?php


namespace Infostud\NetSuiteSdk\Model\SavedSearch;


use Symfony\Component\Serializer\Annotation\SerializedName;

class PaymentItem
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
	 * @SerializedName("salesorder")
	 * @var string
	 */
	private $salesOrder;

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
	 * @return PaymentItem
	 */
	public function setRecordType(string $recordType): PaymentItem
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
	 * @return PaymentItem
	 */
	public function setLastModifiedDate(string $lastModifiedDate): PaymentItem
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
	 * @return PaymentItem
	 */
	public function setTransactionDate(string $transactionDate): PaymentItem
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
	 * @return PaymentItem
	 */
	public function setCustomerId(string $customerId): PaymentItem
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
	 * @return PaymentItem
	 */
	public function setLine(string $line): PaymentItem
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
	 * @return PaymentItem
	 */
	public function setTransactionId(string $transactionId): PaymentItem
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
	 * @return PaymentItem
	 */
	public function setAmount(string $amount): PaymentItem
		{
		$this->amount = $amount;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getSalesOrder(): string
		{
		return $this->salesOrder;
		}

	/**
	 * @param string $salesOrder
	 * @return PaymentItem
	 */
	public function setSalesOrder(string $salesOrder): PaymentItem
		{
		$this->salesOrder = $salesOrder;

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
	 * @return PaymentItem
	 */
	public function setAppliedTransactionName(string $appliedTransactionName): PaymentItem
		{
		$this->appliedTransactionName = $appliedTransactionName;

		return $this;
		}
	}
