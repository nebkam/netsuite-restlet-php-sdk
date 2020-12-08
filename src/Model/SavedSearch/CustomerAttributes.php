<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use DateTime;
use Symfony\Component\Serializer\Annotation\Groups;

class CustomerAttributes
	{
	/**
	 * @Groups("altname")
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $email;
	/**
	 * @Groups("custentity_pib")
	 * @var string
	 */
	private $pib;
	/**
	 * Matični broj u APR / JMBG
	 * @Groups("custentity_matbrpred")
	 * @var string
	 */
	private $registryIdentifier;
	/**
	 * @Groups("datecreated")
	 * @var DateTime
	 */
	private $createdAt;
	/**
	 * @Groups("lastmodifieddate")
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
	public function getPib()
		{
		return $this->pib;
		}

	/**
	 * @param string $pib
	 * @return self
	 */
	public function setPib($pib)
		{
		$this->pib = $pib;

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
