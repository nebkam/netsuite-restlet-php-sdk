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
	 * @var string
	 */
	private $entityId;

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
	public function getEntityId()
		{
		return $this->entityId;
		}

	/**
	 * @param string $entityId
	 * @return self
	 */
	public function setEntityId($entityId)
		{
		$this->entityId = $entityId;

		return $this;
		}
	}
