<?php

namespace Infostud\NetSuiteSdk\Model\NotificationRecipient;

use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\Serializer\Annotation\SerializedName;

class CreateNotificationRecipientResponse
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
	private $notificationRecipientId;
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
	public function getNotificationRecipientId(): ?int
		{
		return $this->notificationRecipientId;
		}

	/**
	 * @param int|null $notificationRecipient
	 * @return self
	 */
	public function setNotificationRecipientId(?int $notificationRecipient): self
		{
		$this->notificationRecipientId = $notificationRecipient;

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
