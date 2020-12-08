<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

class ItemAttributes
	{
	/**
	 * @Groups("itemid")
	 * @var string
	 */
	private $name;
	/**
	 * @Groups("salesdescription")
	 * @var string
	 */
	private $description;
	/**
	 * @var string
	 */
	private $displayName;
	/**
	 * @Groups("baseprice")
	 * @var string
	 */
	private $price;

	/**
	 * @return string
	 */
	public function getName()
		{
		return $this->name;
		}

	/**
	 * @param string $name
	 * @return self
	 */
	public function setName($name)
		{
		$this->name = $name;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getDescription()
		{
		return $this->description;
		}

	/**
	 * @param string $description
	 * @return self
	 */
	public function setDescription($description)
		{
		$this->description = $description;

		return $this;
		}
	
	/**
	 * @return string
	 */
	public function getDisplayName()
		{
		return $this->displayName;
		}

	/**
	 * @param string $displayName
	 * @return self
	 */
	public function setDisplayName($displayName)
		{
		$this->displayName = $displayName;

		return $this;
		}
	
	/**
	 * @return string
	 */
	public function getPrice()
		{
		return $this->price;
		}

	/**
	 * @param string $price
	 * @return self
	 */
	public function setPrice($price)
		{
		$this->price = $price;

		return $this;
		}
	}
