<?php

namespace Infostud\NetSuiteSdk\Model\Contact;

use Symfony\Component\Serializer\Annotation\Groups;

class ContactForm
	{
	/**
	 * @Groups("firstname")
	 * @var string
	 */
	private $firstName;
	/**
	 * @Groups("lastname")
	 * @var string
	 */
	private $lastName;
	/**
	 * @var int
	 */
	private $subsidiary;
	/**
	 * @var string
	 */
	private $email;
	/**
	 * @Groups("company")
	 * @var int
	 */
	private $customerId;
	/**
	 * @var string
	 */
	private $phone;
	/**
	 * @Groups("mobilephone")
	 * @var string
	 */
	private $mobilePhone;

	/**
	 * @return string
	 */
	public function getFirstName()
		{
		return $this->firstName;
		}

	/**
	 * @param string $firstName
	 * @return self
	 */
	public function setFirstName($firstName)
		{
		$this->firstName = $firstName;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getLastName()
		{
		return $this->lastName;
		}

	/**
	 * @param string $lastName
	 * @return self
	 */
	public function setLastName($lastName)
		{
		$this->lastName = $lastName;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getSubsidiary()
		{
		return $this->subsidiary;
		}

	/**
	 * @param int $subsidiary
	 * @return self
	 */
	public function setSubsidiary($subsidiary)
		{
		$this->subsidiary = $subsidiary;

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
	 * @return int
	 */
	public function getCustomerId()
		{
		return $this->customerId;
		}

	/**
	 * @param int $customerId
	 * @return self
	 */
	public function setCustomerId($customerId)
		{
		$this->customerId = $customerId;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getPhone()
		{
		return $this->phone;
		}

	/**
	 * @param string $phone
	 * @return self
	 */
	public function setPhone($phone)
		{
		$this->phone = $phone;

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
	}