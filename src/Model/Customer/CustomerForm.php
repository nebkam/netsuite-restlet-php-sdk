<?php

namespace Infostud\NetSuiteSdk\Model\Customer;

use Symfony\Component\Serializer\Annotation\SerializedName;

class CustomerForm
	{
	/**
	 * @var string|null
	 */
	private $externalId;
	/**
	 * @SerializedName("companyname")
	 * @var string
	 */
	private $companyName;
	/**
	 * @var int
	 */
	private $subsidiary;
	/**
	 * @SerializedName("custentity_pib")
	 * @var string
	 */
	private $pib;
	/**
	 * @SerializedName("custentity_matbrpred")
	 * @var string
	 */
	private $registryIdentifier;
	/**
	 * @SerializedName("custentity_cus_inokupac")
	 * @var bool
	 */
	private $foreigner;
	/**
	 * @SerializedName("isindividual")
	 * @var bool
	 */
	private $individual;
	/**
	 * @var string|null
	 */
	private $email;
	/**
	 * @var string|null
	 */
	private $phone;
	/**
	 * @SerializedName("altphone")
	 * @var string|null
	 */
	private $alternativePhone;
	/**
	 * @var string|null
	 */
	private $url;
	/**
	 * @SerializedName("address")
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
	public function getExternalId(): ?string
		{
		return $this->externalId;
		}

	/**
	 * @param string|null $externalId
	 * @return self
	 */
	public function setExternalId(?string $externalId): self
		{
		$this->externalId = $externalId;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getCompanyName(): string
		{
		return $this->companyName;
		}

	/**
	 * @param string $companyName
	 * @return self
	 */
	public function setCompanyName(string $companyName): self
		{
		$this->companyName = $companyName;

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
	 * @return string
	 */
	public function getPib(): string
		{
		return $this->pib;
		}

	/**
	 * @param string $pib
	 * @return self
	 */
	public function setPib(string $pib): self
		{
		$this->pib = $pib;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getRegistryIdentifier(): string
		{
		return $this->registryIdentifier;
		}

	/**
	 * @param string $registryIdentifier
	 * @return self
	 */
	public function setRegistryIdentifier(string $registryIdentifier): self
		{
		$this->registryIdentifier = $registryIdentifier;

		return $this;
		}

	/**
	 * @return bool
	 */
	public function isForeigner(): bool
		{
		return $this->foreigner;
		}

	/**
	 * @param bool $foreigner
	 * @return self
	 */
	public function setForeigner(bool $foreigner): self
		{
		$this->foreigner = $foreigner;

		return $this;
		}

	/**
	 * @return bool
	 */
	public function isIndividual(): bool
		{
		return $this->individual;
		}

	/**
	 * @param bool $individual
	 * @return self
	 */
	public function setIndividual(bool $individual): self
		{
		$this->individual = $individual;

		return $this;
		}

	public function getEmail(): ?string
		{
		return $this->email;
		}

	public function setEmail(?string $email): self
		{
		$this->email = $email;

		return $this;
		}

	public function getPhone(): ?string
		{
		return $this->phone;
		}

	public function setPhone(?string $phone): self
		{
		$this->phone = $phone;

		return $this;
		}

	public function getAlternativePhone(): ?string
		{
		return $this->alternativePhone;
		}

	public function setAlternativePhone(?string $alternativePhone): self
		{
		$this->alternativePhone = $alternativePhone;

		return $this;
		}

	public function getUrl(): ?string
		{
		return $this->url;
		}

	public function setUrl(?string $url): self
		{
		$this->url = $url;

		return $this;
		}

	/**
	 * @return CustomerFormAddress[]
	 */
	public function getAddresses(): array
		{
		return $this->addresses;
		}

	/**
	 * @param CustomerFormAddress[] $addresses
	 * @return CustomerForm
	 */
	public function setAddresses(array $addresses): self
		{
		$this->addresses = $addresses;

		return $this;
		}

	public function addAddress(CustomerFormAddress $address): self
		{
		$this->addresses[] = $address;

		return $this;
		}

	public function clearAddresses(): self
		{
		$this->addresses = [];

		return $this;
		}
	}
