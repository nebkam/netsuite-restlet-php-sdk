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
	public function getName()
		{
		return $this->name;
		}

	/**
	 * @param string $name
	 * @return self
	 */
	public function setName($name)
		{
		$this->name = $name;

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
	 * @return DateTime
	 */
	public function getCreatedAt()
		{
		return $this->createdAt;
		}

	/**
	 * @param DateTime $createdAt
	 * @return self
	 */
	public function setCreatedAt($createdAt)
		{
		$this->createdAt = $createdAt;

		return $this;
		}

	/**
	 * @return DateTime
	 */
	public function getLastModifiedAt()
		{
		return $this->lastModifiedAt;
		}

	/**
	 * @param DateTime $lastModifiedAt
	 * @return self
	 */
	public function setLastModifiedAt($lastModifiedAt)
		{
		$this->lastModifiedAt = $lastModifiedAt;

		return $this;
		}
	}
