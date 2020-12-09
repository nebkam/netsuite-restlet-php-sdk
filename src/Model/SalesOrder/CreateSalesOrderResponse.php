<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\SerializedName;

class CreateSalesOrderResponse
	{
	/**
	 * @var string
	 */
	private $result;
	/**
	 * @SerializedName("internalid")
	 * @var int|null
	 */
	private $orderId;
	/**
	 * @var string|null
	 */
	private $errorName;
	/**
	 * @SerializedName("message")
	 * @var string|null
	 */
	private $errorMessage;

	/**
	 * @return string
	 */
	public function getResult(): string
		{
		return $this->result;
		}

	/**
	 * @param string $result
	 * @return self
	 */
	public function setResult(string $result): self
		{
		$this->result = $result;

		return $this;
		}

	public function isSuccessful(): bool
		{
		return $this->result === 'ok';
		}

	/**
	 * @return int|null
	 */
	public function getOrderId(): ?int
		{
		return $this->orderId;
		}

	/**
	 * @param int|null $orderId
	 * @return self
	 */
	public function setOrderId(?int $orderId): self
		{
		$this->orderId = $orderId;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getErrorName(): ?string
		{
		return $this->errorName;
		}

	/**
	 * @param string|null $errorName
	 * @return self
	 */
	public function setErrorName(?string $errorName): self
		{
		$this->errorName = $errorName;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getErrorMessage(): ?string
		{
		return $this->errorMessage;
		}

	/**
	 * @param string|null $errorMessage
	 * @return self
	 */
	public function setErrorMessage(?string $errorMessage): self
		{
		$this->errorMessage = $errorMessage;

		return $this;
		}
	}
