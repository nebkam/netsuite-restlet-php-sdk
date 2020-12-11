<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class ContactAttributes
	{
	/**
	 * @SerializedName("entityid")
	 * @var string
	 */
	private $fullName;
	/**
	 * @var string|null
	 */
	private $mobilePhone;
	/**
	 * @var string|null
	 */
	private $email;
	/**
	 * @SerializedName("company")
	 * @var IdNameTuple[]|null
	 */
	private $companies;
	/**
	 * @SerializedName("custentity_contact_location")
	 * @var IdNameTuple[]|null
	 */
	private $locations;

	/**
	 * @return string
	 */
	public function getFullName(): string
		{
		return $this->fullName;
		}

	/**
	 * @param string $fullName
	 * @return self
	 */
	public function setFullName(string $fullName): self
		{
		$this->fullName = $fullName;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getMobilePhone(): ?string
		{
		return $this->mobilePhone;
		}

	/**
	 * @param string|null $mobilePhone
	 * @return self
	 */
	public function setMobilePhone(?string $mobilePhone): self
		{
		$this->mobilePhone = $mobilePhone;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getEmail(): ?string
		{
		return $this->email;
		}

	/**
	 * @param string|null $email
	 * @return self
	 */
	public function setEmail(?string $email): self
		{
		$this->email = $email;

		return $this;
		}

	/**
	 * @return IdNameTuple[]|null
	 */
	public function getCompanies(): ?array
		{
		return $this->companies;
		}

	/**
	 * @param IdNameTuple[]|null $companies
	 * @return self
	 */
	public function setCompanies(?array $companies): self
		{
		$this->companies = $companies;

		return $this;
		}

	/**
	 * @return IdNameTuple[]|null
	 */
	public function getLocations(): ?array
		{
		return $this->locations;
		}

	/**
	 * @param IdNameTuple[]|null $locations
	 * @return self
	 */
	public function setLocations(?array $locations): self
		{
		$this->locations = $locations;

		return $this;
		}
	}
