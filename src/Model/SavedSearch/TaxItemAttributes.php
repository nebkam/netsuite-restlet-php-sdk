<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

class TaxItemAttributes
	{
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $rate;

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
	public function getRate(): string
		{
		return $this->rate;
		}

	/**
	 * @param string $rate
	 * @return self
	 */
	public function setRate(string $rate): self
		{
		$this->rate = $rate;

		return $this;
		}
	}
