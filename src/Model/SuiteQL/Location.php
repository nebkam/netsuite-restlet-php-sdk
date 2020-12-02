<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

use Symfony\Component\Serializer\Annotation\SerializedName;

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
	 * @SerializedName("parent")
	 * @var int|null
	 */
	private $parentId;

	/**
	 * @return int
	 */
	public function getId(): int
		{
		return $this->id;
		}

	/**
	 * @param int $id
	 * @return self
	 */
	public function setId(int $id): self
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

	/**
	 * @return int|null
	 */
	public function getParentId(): ?int
		{
		return $this->parentId;
		}

	/**
	 * @param int|null $parentId
	 * @return self
	 */
	public function setParentId(?int $parentId): self
		{
		$this->parentId = $parentId;

		return $this;
		}
	}
