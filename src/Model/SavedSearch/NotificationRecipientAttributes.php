<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class NotificationRecipientAttributes
	{
	private const EMAIL_DELIMITER = ';';
	/**
	 * @SerializedName("custrecord_rsm_custnp_location")
	 * @var IdNameTuple[]
	 */
	private $location;
	/**
	 * @SerializedName("custrecord_rsm_custnp_description")
	 * @var string|null
	 */
	private $description;
	/**
	 * @SerializedName("custrecord_rsm_custnp_mailto")
	 */
	private $mailTo;
	/**
	 * @SerializedName("custrecord_rsm_custnp_mailcc")
	 */
	private $mailCc;

	/**
	 * @return IdNameTuple[]
	 */
	public function getLocation(): array
		{
		return $this->location;
		}

	/**
	 * @param IdNameTuple[] $location
	 * @return self
	 */
	public function setLocation(array $location): self
		{
		$this->location = $location;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getDescription(): ?string
		{
		return $this->description;
		}

	/**
	 * @param string|null $description
	 * @return self
	 */
	public function setDescription(?string $description): self
		{
		$this->description = $description;

		return $this;
		}

	/**
	 * @return string[]
	 */
	public function getMailTo(): array
		{
		return $this->mailTo;
		}

	/**
	 * @param string|null $mailTo
	 * @return self
	 */
	public function setMailTo(?string $mailTo): self
		{
		$this->mailTo = $mailTo ? explode(self::EMAIL_DELIMITER, $mailTo) : [];

		return $this;
		}

	/**
	 * @return string[]
	 */
	public function getMailCc(): array
		{
		return $this->mailCc;
		}

	/**
	 * @param string|null $mailCc
	 * @return self
	 */
	public function setMailCc(?string $mailCc): self
		{
		$this->mailCc = $mailCc ? explode(self::EMAIL_DELIMITER, $mailCc) : [];

		return $this;
		}
	}
