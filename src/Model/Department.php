<?php

namespace Infostud\NetSuiteSdk\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Department
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
	 * @SerializedName("parent")
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
