<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

class ContactAttributes
	{
	/**
	 * @Groups("entityid")
	 * @var string
	 */
	private $id;
	/**
	 * @var string
	 */
	private $mobilePhone;
	/**
	 * @var string
	 */
	private $email;
	/**
	 * @var TextValueTuple[]
	 */
	private $company;
	/**
	 * @Groups("custentity_contact_location")
	 * @var TextValueTuple[]
	 */
	private $location;

	/**
	 * @return string
	 */
	public function getId()
		{
		return $this->id;
		}

	/**
	 * @param string $id
	 * @return self
	 */
	public function setId($id)
		{
		$this->id = $id;

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
	 * @return TextValueTuple[]
	 */
	public function getCompany()
		{
		return $this->company;
		}

	/**
	 * @param TextValueTuple[] $rows
	 * @return self
	 */
	public function setCompany($company)
		{
		$this->company = $company;

		return $this;
		}

	/**
	 * @return TextValueTuple[]
	 */
	public function getLocation()
		{
		return $this->location;
		}

	/**
	 * @param TextValueTuple[] $rows
	 * @return self
	 */
	public function setLocation($location)
		{
		$this->location = $location;

		return $this;
		}
	}