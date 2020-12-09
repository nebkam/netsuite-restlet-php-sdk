<?php

namespace Infostud\NetSuiteSdk\Model\Customer;

use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\Serializer\Annotation\SerializedName;

class CreateCustomerResponse
	{
	/**
	 * @Enum({"ok", "error"})
	 * @var string
	 */
	private $result;
	/**
	 * @SerializedName("internalid")
	 * @var int|null
	 */
	private $customerId;

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
	public function getCustomerId(): ?int
		{
		return $this->customerId;
		}

	/**
	 * @param int|null $customerId
	 * @return self
	 */
	public function setCustomerId(?int $customerId): self
		{
		$this->customerId = $customerId;

		return $this;
		}
	}
