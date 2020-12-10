<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class TextValueTuple
	{
	/**
	 * @Groups("value")
	 * @var string
	 */
	private $id;
	/**
	 * @Groups("text")
	 * @var string
	 */
	private $name;

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
	 * @return string
	 */
	public function getName()
		{
		return $this->name;
		}

	/**
	 * @param string $attributes
	 * @return self
	 */
	public function setName($name)
		{
		$this->name = $name;

		return $this;
		}
	}