<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Customer
	{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @SerializedName("values")
	 * @var CustomerAttributes
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
	 * @return CustomerAttributes
	 */
	public function getAttributes(): CustomerAttributes
		{
		return $this->attributes;
		}

	/**
	 * @param CustomerAttributes $attributes
	 * @return self
	 */
	public function setAttributes(CustomerAttributes $attributes): self
		{
		$this->attributes = $attributes;

		return $this;
		}
	}
