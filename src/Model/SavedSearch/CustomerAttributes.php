<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use DateTime;

class CustomerAttributes
	{
	/**
	 * @var string
	 */
	private $altname;
	/**
	 * @var string
	 */
	private $email;
	/**
	 * PIB
	 * @var string
	 */
	private $custentity_pib;
	/**
	 * Matični broj u APR / JMBG
	 * @var string
	 */
	private $custentity_matbrpred;
	/**
	 * @var DateTime
	 */
	private $datecreated;
	/**
	 * @var DateTime
	 */
	private $lastmodifieddate;

	/**
	 * @return string
	 */
	public function getName()
		{
		return $this->altname;
		}

	/**
	 * @deprecated
	 * @see getName
	 * @return string
	 */
	public function getAltname()
		{
		return $this->altname;
		}

	/**
	 * @param string $altname
	 * @return self
	 */
	public function setAltname($altname)
		{
		$this->altname = $altname;

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
		return $this->custentity_pib;
		}

	/**
	 * @return string
	 * @see getPib
	 * @deprecated
	 */
	public function getCustentitypib()
		{
		return $this->custentity_pib;
		}

	/**
	 * @param string $custentity_pib
	 * @return self
	 */
	public function setCustentitypib($custentity_pib)
		{
		$this->custentity_pib = $custentity_pib;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getRegistryIdentifier()
		{
		return $this->custentity_matbrpred;
		}

	/**
	 * @deprecated
	 * @see getRegistryIdentifier
	 * @return string
	 */
	public function getCustentitymatbrpred()
		{
		return $this->custentity_matbrpred;
		}

	/**
	 * @param string $custentity_matbrpred
	 * @return self
	 */
	public function setCustentitymatbrpred($custentity_matbrpred)
		{
		$this->custentity_matbrpred = $custentity_matbrpred;

		return $this;
		}

	/**
	 * @return DateTime
	 */
	public function getCreatedAt()
		{
		return $this->datecreated;
		}

	/**
	 * @deprecated
	 * @see getCreatedAt
	 * @return DateTime
	 */
	public function getDatecreated()
		{
		return $this->datecreated;
		}

	/**
	 * @param DateTime $datecreated
	 * @return self
	 */
	public function setDatecreated($datecreated)
		{
		$this->datecreated = $datecreated;

		return $this;
		}

	/**
	 * @return DateTime
	 */
	public function getLastModifiedAt()
		{
		return $this->lastmodifieddate;
		}

	/**
	 * @deprecated
	 * @see getLastModifiedAt
	 * @return DateTime
	 */
	public function getLastmodifieddate()
		{
		return $this->lastmodifieddate;
		}

	/**
	 * @param DateTime $lastmodifieddate
	 * @return self
	 */
	public function setLastmodifieddate($lastmodifieddate)
		{
		$this->lastmodifieddate = $lastmodifieddate;

		return $this;
		}
	}
