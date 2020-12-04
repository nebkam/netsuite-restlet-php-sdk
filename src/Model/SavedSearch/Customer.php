<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class Customer
	{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @Groups("values")
	 * @var CustomerAttributes
	 */
	private $attributes;

	/**
	 * @return string
	 */
	public function getId()
		{
		return $this->id;
		}

	/**
	 * @param string $id
	 * @return self
	 */
	public function setId($id)
		{
		$this->id = $id;

		return $this;
		}

	/**
	 * @return CustomerAttributes
	 */
	public function getAttributes()
		{
		return $this->attributes;
		}

	/**
	 * @param CustomerAttributes $attributes
	 * @return self
	 */
	public function setAttributes($attributes)
		{
		$this->attributes = $attributes;

		return $this;
		}
	}
