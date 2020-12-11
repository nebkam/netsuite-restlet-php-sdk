<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Contact
	{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @SerializedName("values")
	 * @var ContactAttributes
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
	 * @return ContactAttributes
	 */
	public function getAttributes(): ContactAttributes
		{
		return $this->attributes;
		}

	/**
	 * @param ContactAttributes $attributes
	 * @return self
	 */
	public function setAttributes(ContactAttributes $attributes): self
		{
		$this->attributes = $attributes;

		return $this;
		}
	}
