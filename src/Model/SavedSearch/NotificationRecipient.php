<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class NotificationRecipient
	{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @SerializedName("values")
	 * @var NotificationRecipientAttributes
	 */
	private $attributes;

	/**
	 * @return string
	 */
	public function getId(): string
		{
		return $this->id;
		}

	/**
	 * @param string $id
	 * @return self
	 */
	public function setId(string $id): self
		{
		$this->id = $id;

		return $this;
		}

	/**
	 * @return NotificationRecipientAttributes
	 */
	public function getAttributes(): NotificationRecipientAttributes
		{
		return $this->attributes;
		}

	/**
	 * @param NotificationRecipientAttributes $attributes
	 * @return self
	 */
	public function setAttributes(NotificationRecipientAttributes $attributes): self
		{
		$this->attributes = $attributes;

		return $this;
		}
	}
