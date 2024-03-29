<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\SerializedName;

class SalesOrderForm
	{
	public const TYPE_NONE = 'NONE';
	public const EMAIL_STATUS_SKIP = 'SKIP';
	public const EMAIL_STATUS_MANUAL = 'MANUAL';
	public const EMAIL_STATUS_SCHEDULE = 'SCHEDULE';
	public const EMAIL_STATUS_SENT = 'SENT';

	public const PAYMENT_TYPE_ADMINISTRATIVE_BAN = 'Administrativna zabrana';
	public const PAYMENT_TYPE_CASH = 'Gotovina';
	public const PAYMENT_TYPE_IPS_QR_CODE = 'Ips qr kod';
	public const PAYMENT_TYPE_CARD = 'Kartica';
	public const PAYMENT_TYPE_CASH_ON_DELIVERY = 'Pouzece';
	public const PAYMENT_TYPE_BANK_TRANSFER = 'Virman';
	public const PAYMENT_TYPE_WEB_CREDIT = 'Web krediti';

	public const VALID_PAYMENT_TYPES = [
		null,
		self::PAYMENT_TYPE_ADMINISTRATIVE_BAN,
		self::PAYMENT_TYPE_CASH,
		self::PAYMENT_TYPE_IPS_QR_CODE,
		self::PAYMENT_TYPE_CARD,
		self::PAYMENT_TYPE_CASH_ON_DELIVERY,
		self::PAYMENT_TYPE_BANK_TRANSFER,
		self::PAYMENT_TYPE_WEB_CREDIT
	];

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
	 * Overrides `emailStatus` set in the corresponding SalesOrderType in NetSuite
	 * @SerializedName("email_status")
	 * @var string|null
	 */
	private $emailStatus;
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
	/**
	 * In case of SO estimates when startDate and endDate are not set (we haven't activated the service yet)
	 * this field is used to calculate start and end dates after the event of creating a customer deposit (payment) for this SO.
	 *
	 * @SerializedName("custbody_rsm_so_duration")
	 * @var int|null
	 */
	private $serviceDuration;
	/**
	 * @SerializedName("terms")
	 * @var string|null
	 */
	private $paymentTerms;
	/**
	 * @SerializedName("custbody_rsm_napomena_za_print")
	 * @var string|null
	 */
	private $printNote;
	/**
	 * @SerializedName("custbody_rsm_sales_payment_type")
	 * @var string|null
	 */
	private $paymentType;


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
	public function getPaymentAuthorizationCode(): ?string
		{
		return $this->paymentAuthorizationCode;
		}

	/**
	 * @param string|null $code
	 * @return self
	 */
	public function setPaymentAuthorizationCode(?string $code): self
		{
		$this->paymentAuthorizationCode = $code;

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
	 * @return string|null
	 */
	public function getEmailStatus(): ?string
		{
		return $this->emailStatus;
		}

	/**
	 * @param string|null $emailStatus
	 * @return self
	 */
	public function setEmailStatus(?string $emailStatus): self
		{
		if (in_array($emailStatus, [
			null,
			self::EMAIL_STATUS_SKIP,
			self::EMAIL_STATUS_MANUAL,
			self::EMAIL_STATUS_SCHEDULE,
			self::EMAIL_STATUS_SENT
		], true))
			{
			$this->emailStatus = $emailStatus;
			}

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
	 * @return self
	 */
	public function setDaysToPay(?int $daysToPay): self
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
	 * @return self
	 */
	public function setOrderNumber(?string $orderNumber): self
		{
		$this->orderNumber = $orderNumber;

		return $this;
		}

	/**
	 * @return int|null
	 */
	public function getServiceDuration(): ?int
		{
		return $this->serviceDuration;
		}

	/**
	 * @param int|null $serviceDuration
	 * @return self
	 */
	public function setServiceDuration(?int $serviceDuration): self
		{
		$this->serviceDuration = $serviceDuration;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getPrintNote(): ?string
		{
		return $this->printNote;
		}

	/**
	 * @param string|null $printNote
	 * @return self
	 */
	public function setPrintNote(?string $printNote): self
		{
		$this->printNote = $printNote;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getPaymentTerms(): ?string
		{
		return $this->paymentTerms;
		}

	/**
	 * @param string|null $paymentTerms
	 * @return self
	 */
	public function setPaymentTerms(?string $paymentTerms): self
		{
		$this->paymentTerms = $paymentTerms;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getPaymentType(): ?string
		{
		return $this->paymentType;
		}

	/**
	 * @param string|null $paymentType
	 * @return self
	 */
	public function setPaymentType(?string $paymentType): self
		{
		if (in_array($paymentType, self::VALID_PAYMENT_TYPES, true)) {
			$this->paymentType = $paymentType;
		}

		return $this;
		}
	}
