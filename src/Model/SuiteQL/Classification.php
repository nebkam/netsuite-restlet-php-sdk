<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

class Classification implements SuiteQLItem
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
	}
