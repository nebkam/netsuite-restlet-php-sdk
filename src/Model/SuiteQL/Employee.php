<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

use Symfony\Component\Serializer\Annotation\Groups;

class Employee implements SuiteQLItem
	{
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @Groups("entityid")
	 * @var string
	 */
	private $name;

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
	}
