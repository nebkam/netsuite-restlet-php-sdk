<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\SerializedName;

class SalesOrderForm
	{

	public const TYPE_NONE = 'NONE';

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
	 * @var string
	 */
	private $transactionDate;
	/**
	 * @SerializedName("custbody_rsm_so_type")
	 * @var string
	 */
	private $type;
	/**
	 * @SerializedName("custbody_rsm_infs_fakturista")
	 * @var int|null
	 */
	private $createdBy;
	/**
	 * @SerializedName("custbody_rsm_infs_representative")
	 * @var int|null
	 */
	private $appointedSeller;
	/**
	 * @SerializedName("custbody_rsm_force_invoice")
	 * @var bool|null
	 */
	private $invoiceImmediately;
	/**
	 * @var string|null
	 */
	private $memo;
	/**
	 * @SerializedName("custbody_rsm_internal_memo")
	 * @var string|null
	 */
	private $internalMemo;
	/**
	 * @SerializedName("startdate")
	 * @var string|null
	 */
	private $startDate;
	/**
	 * @SerializedName("enddate")
	 * @var string|null
	 */
	private $endDate;
	/**
	 * Payment (authorization) code
	 *
	 * @SerializedName("custbody_rsm_auth_payment_code")
	 * @var string|null
	 */
	private $paymentAuthorizationCode;
	/**
	 * @SerializedName("custbody_rsm_additional_cc_email")
	 * @var string|null
	 */
	private $emailCc;
	/**
	 * @SerializedName("custbody_rsm_additional_bcc_email")
	 * @var string|null
	 */
	private $emailBcc;
	/**
	 * Only shows the number of installments for sales order estimates. This does not effect the billing schedule (invoice installments).
	 *
	 * @SerializedName("custbody_rsm_so_brojrata")
	 * @var int|null
	 */
	private $installmentCount;
	/**
	 *
	 * @SerializedName("custbody_rsm_broj_dana_uplata")
	 * @var int|null
	 */
	private $daysToPay;
	/**
	 * @SerializedName("custbody_rsm_crm_ordernum")
	 * @var string|null
	 */
	private $orderNumber;


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
	 * @return string
	 */
	public function getTransactionDate(): string
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
	public function setTransactionDate(string $transactionDate): self
		{
		$this->transactionDate = $transactionDate;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getType(): string
		{
		return $this->type;
		}

	/**
	 * @param string $type
	 * @return self
	 */
	public function setType(string $type): self
		{
		$this->type = $type;

		return $this;
		}

	/**
	 * @return int|null
	 */
	public function getCreatedBy(): ?int
		{
		return $this->createdBy;
		}

	/**
	 * @param int|null $id
	 * @return self
	 */
	public function setCreatedBy(?int $id): self
		{
		$this->createdBy = $id;

		return $this;
		}

	/**
	 * @return int|null
	 */
	public function getAppointedSeller(): ?int
		{
		return $this->appointedSeller;
		}

	/**
	 * @param int|null $id
	 * @return self
	 */
	public function setAppointedSeller(?int $id): self
		{
		$this->appointedSeller = $id;

		return $this;
		}

	/**
	 * @return bool|null
	 */
	public function getInvoiceImmediately(): ?bool
		{
		return $this->invoiceImmediately;
		}

	/**
	 * @param bool|null $value
	 * @return self
	 */
	public function setInvoiceImmediately(?bool $value): self
		{
		$this->invoiceImmediately = $value;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getMemo(): ?string
		{
		return $this->memo;
		}

	/**
	 * @param string|null $memo
	 * @return self
	 */
	public function setMemo(?string $memo): self
		{
		$this->memo = $memo;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getStartDate(): ?string
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
	 */
	public function setStartDate(?string $startDate): self
		{
		$this->startDate = $startDate;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getEndDate(): ?string
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
	 */
	public function setEndDate(?string $endDate): self
		{
		$this->endDate = $endDate;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getInternalMemo(): ?string
		{
		return $this->internalMemo;
		}

	/**
	 * @param string|null $internalMemo
	 * @return SalesOrderForm
	 */
	public function setInternalMemo(?string $internalMemo): self
		{
		$this->internalMemo = $internalMemo;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getPaymentAuthorizationCode(): ?string
		{
		return $this->paymentAuthorizationCode;
		}

	/**
	 * @param string|null $paymentAuthorizationCode
	 * @return SalesOrderForm
	 */
	public function setPaymentAuthorizationCode(?string $paymentAuthorizationCode): self
		{
		$this->paymentAuthorizationCode = $paymentAuthorizationCode;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getEmailCc(): ?string
		{
		return $this->emailCc;
		}

	/**
	 * @param string|null $emailCc
	 * @return SalesOrderForm
	 */
	public function setEmailCc(?string $emailCc): self
		{
		$this->emailCc = $emailCc;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getEmailBcc(): ?string
		{
		return $this->emailBcc;
		}

	/**
	 * @param string|null $emailBcc
	 * @return SalesOrderForm
	 */
	public function setEmailBcc(?string $emailBcc): self
		{
		$this->emailBcc = $emailBcc;

		return $this;
		}

	/**
	 * @return int|null
	 */
	public function getInstallmentCount(): ?int
		{
		return $this->installmentCount;
		}

	/**
	 * @param int|null $installmentCount
	 * @return SalesOrderForm
	 */
	public function setInstallmentCount(?int $installmentCount): self
		{
		$this->installmentCount = $installmentCount;

		return $this;
		}

	/**
	 * @return int|null
	 */
	public function getDaysToPay(): ?int
		{
		return $this->daysToPay;
		}

	/**
	 * @param int|null $daysToPay
	 * @return SalesOrderForm
	 */
	public function setDaysToPay(?int $daysToPay): SalesOrderForm
		{
		$this->daysToPay = $daysToPay;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getOrderNumber(): ?string
		{
		return $this->orderNumber;
		}

	/**
	 * @param string|null $orderNumber
	 * @return SalesOrderForm
	 */
	public function setOrderNumber(?string $orderNumber): SalesOrderForm
		{
		$this->orderNumber = $orderNumber;

		return $this;
		}
	}
