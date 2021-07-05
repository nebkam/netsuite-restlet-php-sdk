<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\SerializedName;

class UpdateSalesOrderResponse
	{
	/**
	 * @var string
	 */
	private $result;
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
