<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class ContactAttributes
	{
	/**
	 * @Groups("entityid")
	 * @var string
	 */
	private $fullName;
	/**
	 * @var string
	 */
	private $mobilePhone;
	/**
	 * @var string
	 */
	private $email;
	/**
	 * @Groups("company")
	 * @var IdNameTuple[]
	 */
	private $companies;
	/**
	 * @Groups("custentity_contact_location")
	 * @var IdNameTuple[]
	 */
	private $locations;

	/**
	 * @return string
	 */
	public function getFullName()
		{
		return $this->fullName;
		}

	/**
	 * @param string $fullName
	 * @return self
	 */
	public function setFullName($fullName)
		{
		$this->fullName = $fullName;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getMobilePhone()
		{
		return $this->mobilePhone;
		}

	/**
	 * @param string $mobilePhone
	 * @return self
	 */
	public function setMobilePhone($mobilePhone)
		{
		$this->mobilePhone = $mobilePhone;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getEmail()
		{
		return $this->email;
		}

	/**
	 * @param string $email
	 * @return self
	 */
	public function setEmail($email)
		{
		$this->email = $email;

		return $this;
		}

	/**
	 * @return IdNameTuple[]
	 */
	public function getCompanies()
		{
		return $this->companies;
		}

	/**
	 * @param IdNameTuple[] $companies
	 * @return self
	 */
	public function setCompanies($companies)
		{
		$this->companies = $companies;

		return $this;
		}

	/**
	 * @return IdNameTuple[]
	 */
	public function getLocations()
		{
		return $this->locations;
		}

	/**
	 * @param IdNameTuple[] $locations
	 * @return self
	 */
	public function setLocations($locations)
		{
		$this->locations = $locations;

		return $this;
		}
	}
