<?php

namespace Infostud\NetSuiteSdk\Model\Customer;

use Symfony\Component\Serializer\Annotation\Groups;

class CustomerFormAddress
	{
	const COUNTRY_SERBIA = 'RS';
	/**
	 * @var string
	 */
	private $label;
	/**
	 * @var string
	 */
	private $city;
	/**
	 * @Groups("addr1")
	 * @var string
	 */
	private $addressLine1;
	/**
	 * @Groups("addr2")
	 * @var string
	 */
	private $addressLine2;
	/**
	 * @Groups("zip")
	 * @var string
	 */
	private $postalCode;
	/**
	 * @var string
	 */
	private $country;

	/**
	 * @return string
	 */
	public function getLabel()
		{
		return $this->label;
		}

	/**
	 * @param string $label
	 * @return self
	 */
	public function setLabel($label)
		{
		$this->label = $label;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getCity()
		{
		return $this->city;
		}

	/**
	 * @param string $city
	 * @return self
	 */
	public function setCity($city)
		{
		$this->city = $city;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getAddressLine1()
		{
		return $this->addressLine1;
		}

	/**
	 * @param string $addressLine1
	 * @return self
	 */
	public function setAddressLine1($addressLine1)
		{
		$this->addressLine1 = $addressLine1;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getAddressLine2()
		{
		return $this->addressLine2;
		}

	/**
	 * @param string $addressLine2
	 * @return self
	 */
	public function setAddressLine2($addressLine2)
		{
		$this->addressLine2 = $addressLine2;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getPostalCode()
		{
		return $this->postalCode;
		}

	/**
	 * @param string $postalCode
	 * @return self
	 */
	public function setPostalCode($postalCode)
		{
		$this->postalCode = $postalCode;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getCountry()
		{
		return $this->country;
		}

	/**
	 * @param string $country
	 * @return self
	 */
	public function setCountry($country)
		{
		$this->country = $country;

		return $this;
		}
	}
