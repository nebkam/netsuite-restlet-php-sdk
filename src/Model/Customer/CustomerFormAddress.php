<?php

namespace Infostud\NetSuiteSdk\Model\Customer;

use Symfony\Component\Serializer\Annotation\SerializedName;

class CustomerFormAddress
	{
	public const COUNTRY_SERBIA = 'RS';
	/**
	 * @var string
	 */
	private $label;
	/**
	 * @var string
	 */
	private $city;
	/**
	 * @SerializedName("addr1")
	 * @var string|null
	 */
	private $addressLine1;
	/**
	 * @SerializedName("addr2")
	 * @var string|null
	 */
	private $addressLine2;
	/**
	 * @SerializedName("zip")
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
	public function getCity(): string
		{
		return $this->city;
		}

	/**
	 * @param string $city
	 * @return self
	 */
	public function setCity(string $city): self
		{
		$this->city = $city;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getAddressLine1(): ?string
		{
		return $this->addressLine1;
		}

	/**
	 * @param string|null $addressLine1
	 * @return self
	 */
	public function setAddressLine1(?string $addressLine1): self
		{
		$this->addressLine1 = $addressLine1;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getAddressLine2(): ?string
		{
		return $this->addressLine2;
		}

	/**
	 * @param string|null $addressLine2
	 * @return self
	 */
	public function setAddressLine2(?string $addressLine2): self
		{
		$this->addressLine2 = $addressLine2;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getPostalCode(): string
		{
		return $this->postalCode;
		}

	/**
	 * @param string $postalCode
	 * @return self
	 */
	public function setPostalCode(string $postalCode): self
		{
		$this->postalCode = $postalCode;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getCountry(): string
		{
		return $this->country;
		}

	/**
	 * @param string $country
	 * @return self
	 */
	public function setCountry(string $country): self
		{
		$this->country = $country;

		return $this;
		}
	}
