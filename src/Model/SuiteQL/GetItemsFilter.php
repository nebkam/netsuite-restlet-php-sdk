<?php


namespace Infostud\NetSuiteSdk\Model\SuiteQL;


class GetItemsFilter implements SuiteQLFilter
	{
	/**
	 * @var int|null
	 */
	private $location = null;

	/**
	 * @return int|null
	 */
	public function getLocation(): ?int
		{
		return $this->location;
		}

	/**
	 * @param int|null $location
	 * @return GetItemsFilter
	 */
	public function setLocation(?int $location): GetItemsFilter
		{
		$this->location = $location;

		return $this;
		}


	public function getWhereString(): string
		{
		if (is_int($this->location)) {
			return 'WHERE location = '.$this->location;
		}
		return '';
		}


	}
