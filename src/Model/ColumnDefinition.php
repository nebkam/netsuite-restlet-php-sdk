<?php

namespace Infostud\NetSuiteSdk\Model;

use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\Serializer\Annotation\SerializedName;

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
	 * @SerializedName("sortdir")
	 * TODO Check for other available values
	 * @Enum({"NONE"})
	 * @var string
	 */
	private $sortDirection;

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

	/**
	 * @return string
	 */
	public function getLabel(): string
		{
		return $this->label;
		}

	/**
	 * @param string $label
	 * @return self
	 */
	public function setLabel(string $label): self
		{
		$this->label = $label;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getType(): string
		{
		return $this->type;
		}

	/**
	 * @param string $type
	 * @return self
	 */
	public function setType(string $type): self
		{
		$this->type = $type;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getSortDirection(): string
		{
		return $this->sortDirection;
		}

	/**
	 * @param string $sortDirection
	 * @return self
	 */
	public function setSortDirection(string $sortDirection): self
		{
		$this->sortDirection = $sortDirection;

		return $this;
		}
	}
