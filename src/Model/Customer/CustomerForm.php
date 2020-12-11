<?php

namespace Infostud\NetSuiteSdk\Model\Customer;

use Symfony\Component\Serializer\Annotation\Groups;

class CustomerForm
	{
	/**
	 * @var string|null
	 */
	private $externalId;
	/**
	 * @Groups("companyname")
	 * @var string
	 */
	private $companyName;
	/**
	 * @var int
	 */
	private $subsidiary;
	/**
	 * @Groups("custentity_pib")
	 * @var string
	 */
	private $vatIdentifier;
	/**
	 * @Groups("custentity_matbrpred")
	 * @var string
	 */
	private $registryIdentifier;
	/**
	 * @Groups("custentity_cus_inokupac")
	 * @var bool
	 */
	private $foreigner;
	/**
	 * @Groups("isindividual")
	 * @var bool
	 */
	private $individual;
	/**
	 * @var string
	 */
	private $email;
	/**
	 * @var string
	 */
	private $url;
	/**
	 * @var string
	 */
	private $phone;
	/**
	 * @Groups("altphone")
	 * @var string
	 */
	private $alternativePhone;
	/**
	 * @Groups("address")
	 * @var CustomerFormAddress[]
	 */
	private $addresses;

	public function __construct()
		{
		$this->foreigner  = false;
		$this->individual = false;
		$this->addresses  = [];
		}

	/**
	 * @return string|null
	 */
	public function getExternalId()
		{
		return $this->externalId;
		}

	/**
	 * @param string|null $externalId
	 * @return self
	 */
	public function setExternalId($externalId)
		{
		$this->externalId = $externalId;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getCompanyName()
		{
		return $this->companyName;
		}

	/**
	 * @param string $companyName
	 * @return self
	 */
	public function setCompanyName($companyName)
		{
		$this->companyName = $companyName;

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
	public function getVatIdentifier()
		{
		return $this->vatIdentifier;
		}

	/**
	 * @param string $vatIdentifier
	 * @return self
	 */
	public function setVatIdentifier($vatIdentifier)
		{
		$this->vatIdentifier = $vatIdentifier;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getRegistryIdentifier()
		{
		return $this->registryIdentifier;
		}

	/**
	 * @param string $registryIdentifier
	 * @return self
	 */
	public function setRegistryIdentifier($registryIdentifier)
		{
		$this->registryIdentifier = $registryIdentifier;

		return $this;
		}

	/**
	 * @return bool
	 */
	public function isForeigner()
		{
		return $this->foreigner;
		}

	/**
	 * @param bool $foreigner
	 * @return self
	 */
	public function setForeigner($foreigner)
		{
		$this->foreigner = $foreigner;

		return $this;
		}

	/**
	 * @return bool
	 */
	public function isIndividual()
		{
		return $this->individual;
		}

	/**
	 * @param bool $individual
	 * @return self
	 */
	public function setIndividual($individual)
		{
		$this->individual = $individual;

		return $this;
		}

	/**
	 * @return CustomerFormAddress[]
	 */
	public function getAddresses()
		{
		return $this->addresses;
		}

	/**
	 * @param CustomerFormAddress[] $addresses
	 * @return CustomerForm
	 */
	public function setAddresses($addresses)
		{
		$this->addresses = $addresses;

		return $this;
		}

	public function addAddress(CustomerFormAddress $address)
		{
		$this->addresses[] = $address;

		return $this;
		}

	public function clearAddresses()
		{
		$this->addresses = [];

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
	 */
	public function setEmail($email)
		{
		$this->email = $email;
		}

	/**
	 * @return string
	 */
	public function getUrl()
		{
		return $this->url;
		}

	/**
	 * @param string $url
	 * @return self
	 */
	public function setUrl($url)
		{
		$this->url = $url;

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
	public function getAlternativePhone()
		{
		return $this->alternativePhone;
		}

	/**
	 * @param string $alternativePhone
	 * @return self
	 */
	public function setAlternativePhone($alternativePhone)
		{
		$this->alternativePhone = $alternativePhone;

		return $this;
		}
	}
