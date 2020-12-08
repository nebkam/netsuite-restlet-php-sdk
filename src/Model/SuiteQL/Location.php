<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

use Symfony\Component\Serializer\Annotation\Groups;

class Location implements SuiteQLItem
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
	 * @Groups("parent")
	 * @var int|null
	 */
	private $parentId;

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
		return $this->parentId;
		}

	/**
	 * @param int|null $parentId
	 * @return self
	 */
	public function setParentId($parentId)
		{
		$this->parentId = $parentId;

		return $this;
		}
	}
