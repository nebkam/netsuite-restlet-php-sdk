<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\Groups;

class SalesOrderMetaItem
	{
	/**
	 * @var string
	 */
	private $recordType;
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var SalesOrderMetaItemValue
	 */
	private $values;

	/**
	 * @return string
	 */
	public function getRecordType()
		{
		return $this->recordType;
		}

	/**
	 * @param string $recordType
	 */
	public function setRecordType($recordType)
		{
		$this->recordType = $recordType;
		}

	/**
	 * @return int
	 */
	public function getId()
		{
		return $this->id;
		}

	/**
	 * @param int $id
	 */
	public function setId($id)
		{
		$this->id = $id;
		}

	/**
	 * @return SalesOrderMetaItemValue
	 */
	public function getValues()
		{
		return $this->values;
		}

	/**
	 * @param SalesOrderMetaItemValue $values
	 */
	public function setValues($values)
		{
		$this->values = $values;
		}
	}
