<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class IdNameTuple
	{
	/**
	 * @SerializedName("value")
	 * @var string
	 */
	private $id;
	/**
	 * @SerializedName("text")
	 * @var string
	 */
	private $name;

	/**
	 * @return string
	 */
	public function getId(): string
		{
		return $this->id;
		}

	/**
	 * @param string $id
	 * @return self
	 */
	public function setId(string $id): self
		{
		$this->id = $id;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getName(): string
		{
		return $this->name;
		}

	/**
	 * @param string $name
	 * @return self
	 */
	public function setName(string $name): self
		{
		$this->name = $name;

		return $this;
		}
	}
