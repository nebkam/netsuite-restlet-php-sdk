<?php

namespace Infostud\NetSuiteSdk\Model\NotificationRecipient;

use Symfony\Component\Serializer\Annotation\SerializedName;

class NotificationRecipientForm
	{
	private const EMAIL_SEPARATOR = ';';
	/**
	 * @var string|null
	 */
	private $description;
	/**
	 * @SerializedName("email_to")
	 */
	private $emailTo;
	/**
	 * @SerializedName("email_cc")
	 */
	private $emailCc;
	/**
	 * @SerializedName("custrecord_rsm_custnp_location")
	 * @var int[]
	 */
	private $locations;
	/**
	 * @var int
	 */
	private $customer;

	/**
	 * @return string|null
	 */
	public function getDescription(): ?string
		{
		return $this->description;
		}

	/**
	 * @param string|null $description
	 * @return NotificationRecipientForm
	 */
	public function setDescription(?string $description): NotificationRecipientForm
		{
		$this->description = $description;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getEmailTo(): ?string
		{
		return $this->emailTo ? implode(self::EMAIL_SEPARATOR, $this->emailTo) : null;
		}

	/**
	 * @param string[]|null $emailTo
	 * @return self
	 */
	public function setEmailTo(?array $emailTo): self
		{
		$this->emailTo = $emailTo;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getEmailCc(): ?string
		{
		return $this->emailCc ? implode(self::EMAIL_SEPARATOR, $this->emailCc) : null;
		}

	/**
	 * @param string[]|null $emailCc
	 * @return self
	 */
	public function setEmailCc(?array $emailCc): self
		{
		$this->emailCc = $emailCc;

		return $this;
		}

	/**
	 * @return int[]
	 */
	public function getLocations(): array
		{
		return $this->locations;
		}

	/**
	 * @param int[] $locations
	 * @return self
	 */
	public function setLocations(array $locations): self
		{
		$this->locations = $locations;

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
	}
