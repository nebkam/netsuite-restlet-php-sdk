<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

class Department implements SuiteQLItem
	{
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var int|null
	 */
	private $parent;

	/**
	 * @return int
	 */
	public function getId()
		{
		return $this->id;
		}

	/**
	 * @param int $id
	 * @return self
	 */
	public function setId($id)
		{
		$this->id = $id;

		return $this;
		}

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
	 * @return int|null
	 */
	public function getParentId()
		{
		return $this->parent;
		}

	/**
	 * @deprecated
	 * @see getParentId
	 * @return int|null
	 */
	public function getParent()
		{
		return $this->parent;
		}

	/**
	 * @param int|null $parent
	 * @return self
	 */
	public function setParent($parent)
		{
		$this->parent = $parent;

		return $this;
		}
	}
