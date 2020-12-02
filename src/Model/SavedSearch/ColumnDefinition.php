<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Doctrine\Common\Annotations\Annotation\Enum;

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
	 * TODO Check for other available values
	 * @Enum({"NONE"})
	 * @var string
	 */
	private $sortdir;

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
	 * @deprecated
	 * @see getSortDirection
	 * @return string
	 */
	public function getSortdir()
		{
		return $this->sortdir;
		}

	/**
	 * Readable alias
	 * @return string
	 */
	public function getSortDirection()
		{
		return $this->sortdir;
		}

	/**
	 * @param string $sortdir
	 * @return self
	 */
	public function setSortdir($sortdir)
		{
		$this->sortdir = $sortdir;

		return $this;
		}
	}
