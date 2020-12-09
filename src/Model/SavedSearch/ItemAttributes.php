<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class ItemAttributes
	{
	/**
	 * @SerializedName("itemid")
	 * @var string
	 */
	private $name;
	/**
	 * @SerializedName("salesdescription")
	 * @var string
	 */
	private $description;
	/**
	 * @var string
	 */
	private $displayName;
	/**
	 * @SerializedName("baseprice")
	 * @var string
	 */
	private $price;

	/**
	 * @return string
	 */
	public function getName(): string
		{
		return $this->name;
		}

	/**
	 * @param string $name
	 * @return self
	 */
	public function setName(string $name): self
		{
		$this->name = $name;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getDescription(): string
		{
		return $this->description;
		}

	/**
	 * @param string $description
	 * @return self
	 */
	public function setDescription(string $description): self
		{
		$this->description = $description;

		return $this;
		}
	
	/**
	 * @return string
	 */
	public function getDisplayName(): string
		{
		return $this->displayName;
		}

	/**
	 * @param string $displayName
	 * @return self
	 */
	public function setDisplayName(string $displayName): self
		{
		$this->displayName = $displayName;

		return $this;
		}
	
	/**
	 * @return string
	 */
	public function getPrice(): string
		{
		return $this->price;
		}

	/**
	 * @param string $price
	 * @return self
	 */
	public function setPrice(string $price): self
		{
		$this->price = $price;

		return $this;
		}
	}
