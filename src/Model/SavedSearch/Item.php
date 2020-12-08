<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class Item
	{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @Groups("values")
	 * @var ItemAttributes
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
	 * @return ItemAttributes
	 */
	public function getAttributes()
		{
		return $this->attributes;
		}

	/**
	 * @param ItemAttributes $attributes
	 * @return self
	 */
	public function setAttributes($attributes)
		{
		$this->attributes = $attributes;

		return $this;
		}
	}
