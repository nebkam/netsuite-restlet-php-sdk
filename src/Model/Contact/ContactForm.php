<?php

namespace Infostud\NetSuiteSdk\Model\Contact;

use Symfony\Component\Serializer\Annotation\SerializedName;

class ContactForm
	{
	/**
	 * @SerializedName("firstname")
	 * @var string
	 */
	private $firstName;
	/**
	 * @SerializedName("lastname")
	 * @var string|null
	 */
	private $lastName;
	/**
	 * @var int
	 */
	private $subsidiary;
	/**
	 * @var string|null
	 */
	private $email;
	/**
	 * @var int
	 */
	private $company;
	/**
	 * @var string|null
	 */
	private $phone;
	/**
	 * @SerializedName("mobilephone")
	 * @var string|null
	 */
	private $mobilePhone;
	/**
	 * @SerializedName("custentity_contact_location")
	 * @var int[]
	 */
	private $locations;

	/**
	 * @return string
	 */
	public function getFirstName(): string
		{
		return $this->firstName;
		}

	/**
	 * @param string $firstName
	 * @return self
	 */
	public function setFirstName(string $firstName): self
		{
		$this->firstName = $firstName;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getLastName(): ?string
		{
		return $this->lastName;
		}

	/**
	 * @param string|null $lastName
	 * @return self
	 */
	public function setLastName(?string $lastName): self
		{
		$this->lastName = $lastName;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getSubsidiary(): int
		{
		return $this->subsidiary;
		}

	/**
	 * @param int $subsidiary
	 * @return self
	 */
	public function setSubsidiary(int $subsidiary): self
		{
		$this->subsidiary = $subsidiary;

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
	 * @return int
	 */
	public function getCompany(): int
		{
		return $this->company;
		}

	/**
	 * Set the Company (Customer/Vendor) ID
	 *
	 * @param int $company
	 * @return self
	 */
	public function setCompany(int $company): self
		{
		$this->company = $company;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getPhone(): ?string
		{
		return $this->phone;
		}

	/**
	 * @param string|null $phone
	 * @return self
	 */
	public function setPhone(?string $phone): self
		{
		$this->phone = $phone;

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
	 * @return int[]|null
	 */
	public function getLocations(): ?array
		{
		return $this->locations;
		}

	/**
	 * @param int[] $locations
	 * @return self
	 */
	public function setLocations(?array $locations): self
		{
		$this->locations = $locations;

		return $this;
		}
	}
