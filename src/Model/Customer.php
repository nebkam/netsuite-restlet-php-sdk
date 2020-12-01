<?php

namespace Infostud\NetSuiteSdk\Model;

class Customer
	{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var CustomerAttributes
	 */
	private $values;

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
	 * @deprecated
	 * @see getAttributes
	 * @return CustomerAttributes
	 */
	public function getValues()
		{
		return $this->values;
		}

	/**
	 * @return CustomerAttributes
	 */
	public function getAttributes()
		{
		return $this->values;
		}


	/**
	 * @param CustomerAttributes $values
	 * @return self
	 */
	public function setValues($values)
		{
		$this->values = $values;

		return $this;
		}
	}
