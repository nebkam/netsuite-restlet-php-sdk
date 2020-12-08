<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\Serializer\Annotation\Groups;

class ColumnDefinition
	{
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $label;
	/**
	 * TODO Check if there are any more available values
	 * @Enum({"text", "email", "phone", "select", "datetime"})
	 * @var string
	 */
	private $type;
	/**
	 * @Groups("sortdir")
	 * @var string
	 */
	private $sortDirection;

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
	public function getLabel()
		{
		return $this->label;
		}

	/**
	 * @param string $label
	 * @return self
	 */
	public function setLabel($label)
		{
		$this->label = $label;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getType()
		{
		return $this->type;
		}

	/**
	 * @param string $type
	 * @return self
	 */
	public function setType($type)
		{
		$this->type = $type;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getSortDirection()
		{
		return $this->sortDirection;
		}

	/**
	 * @param string $sortDirection
	 * @return self
	 */
	public function setSortDirection($sortDirection)
		{
		$this->sortDirection = $sortDirection;

		return $this;
		}
	}
