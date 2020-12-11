<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class TaxItem
	{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @SerializedName("values")
	 * @var TaxItemAttributes
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
	 * @return TaxItemAttributes
	 */
	public function getAttributes(): TaxItemAttributes
		{
		return $this->attributes;
		}

	/**
	 * @param TaxItemAttributes $attributes
	 * @return self
	 */
	public function setAttributes(TaxItemAttributes $attributes): self
		{
		$this->attributes = $attributes;

		return $this;
		}
	}
