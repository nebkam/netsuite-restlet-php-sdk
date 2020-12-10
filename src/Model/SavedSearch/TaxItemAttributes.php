<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

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

	/**
	 * @return string
	 */
	public function getRate()
		{
		return $this->rate;
		}

	/**
	 * @param string $rate
	 * @return self
	 */
	public function setRate($rate)
		{
		$this->rate = $rate;

		return $this;
		}
	}