<?php

namespace Infostud\NetSuiteSdk\Model;

use DateTime;
use Symfony\Component\Serializer\Annotation\SerializedName;

class CustomerAttributes
	{
	/**
	 * @SerializedName("altname")
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $email;
	/**
	 * PIB
	 * @SerializedName("custentity_pib")
	 * @var string
	 */
	private $vatIdentifier;
	/**
	 * Matični broj u APR / JMBG
	 * @SerializedName("custentity_matbrpred")
	 * @var string
	 */
	private $registryIdentifier;
	/**
	 * @SerializedName("datecreated")
	 * @var DateTime
	 */
	private $createdAt;
	/**
	 * @SerializedName("lastmodifieddate")
	 * @var DateTime
	 */
	private $lastModifiedAt;

	/**
	 * @return string
	 */
	public function getName(): string
		{
		return $this->name;
		}

	/**
	 * @param string $name
	 * @return self
	 */
	public function setName(string $name): self
		{
		$this->name = $name;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getEmail(): string
		{
		return $this->email;
		}

	/**
	 * @param string $email
	 * @return self
	 */
	public function setEmail(string $email): self
		{
		$this->email = $email;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getVatIdentifier(): string
		{
		return $this->vatIdentifier;
		}

	/**
	 * @param string $vatIdentifier
	 * @return self
	 */
	public function setVatIdentifier(string $vatIdentifier): self
		{
		$this->vatIdentifier = $vatIdentifier;

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
	 * @return DateTime
	 */
	public function getCreatedAt(): DateTime
		{
		return $this->createdAt;
		}

	/**
	 * @param DateTime $createdAt
	 * @return self
	 */
	public function setCreatedAt(DateTime $createdAt): self
		{
		$this->createdAt = $createdAt;

		return $this;
		}

	/**
	 * @return DateTime
	 */
	public function getLastModifiedAt(): DateTime
		{
		return $this->lastModifiedAt;
		}

	/**
	 * @param DateTime $lastModifiedAt
	 * @return self
	 */
	public function setLastModifiedAt(DateTime $lastModifiedAt): self
		{
		$this->lastModifiedAt = $lastModifiedAt;

		return $this;
		}
	}
