<?php

namespace Infostud\NetSuiteSdk\Model\Contact;

use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\Serializer\Annotation\SerializedName;

class CreateContactResponse
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
	private $contactId;
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

	/**
	 * @return bool
	 */
	public function isSuccessful(): bool
		{
		return $this->result === 'ok';
		}

	/**
	 * @return int|null
	 */
	public function getContactId(): ?int
		{
		return $this->contactId;
		}

	/**
	 * @param int|null $contactId
	 * @return self
	 */
	public function setContactId(?int $contactId): self
		{
		$this->contactId = $contactId;

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
