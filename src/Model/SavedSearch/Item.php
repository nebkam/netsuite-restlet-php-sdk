<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Item
	{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @SerializedName("values")
	 * @var ItemAttributes
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
	 * @return ItemAttributes
	 */
	public function getAttributes(): ItemAttributes
		{
		return $this->attributes;
		}

	/**
	 * @param ItemAttributes $attributes
	 * @return self
	 */
	public function setAttributes(ItemAttributes $attributes): self
		{
		$this->attributes = $attributes;

		return $this;
		}
	}
