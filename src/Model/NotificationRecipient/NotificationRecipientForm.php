<?php

namespace Infostud\NetSuiteSdk\Model\NotificationRecipient;

use Symfony\Component\Serializer\Annotation\Groups;

class NotificationRecipientForm
	{
	/**
	 * @var string
	 */
	private $description;
	/**
	 * @Groups("email_to")
	 * @var string
	 */
	private $emailTo;
	/**
	 * @Groups("email_cc")
	 * @var string
	 */
	private $emailCc;
	/**
	 * @Groups("custrecord_rsm_custnp_location")
	 * @var int[]
	 */
	private $locations;
	/**
	 * @var int
	 */
	private $customer;

	/**
	 * @return string
	 */
	public function getDescription()
		{
		return $this->description;
		}

	/**
	 * @param string $description
	 * @return self
	 */
	public function setDescription($description)
		{
		$this->description = $description;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getEmailTo()
		{
		return $this->emailTo;
		}

	/**
	 * @param string[] $emailTo
	 * @return self
	 */
	public function setEmailTo($emailTo)
		{
		$this->emailTo = implode(';',$emailTo);

		return $this;
		}

	/**
	 * @return string
	 */
	public function getEmailCc()
		{
		return $this->emailCc;
		}

	/**
	 * @param string[] $emailCc
	 * @return self
	 */
	public function setEmailCc($emailCc)
		{
		$this->emailCc = implode(';',$emailCc);

		return $this;
		}

	/**
	 * @return int[]
	 */
	public function getLocations()
		{
		return $this->locations;
		}

	/**
	 * @param int[] $locations
	 *
	 * @return self
	 */
	public function setLocations($locations)
		{
		$this->locations = $locations;

		return $this;
		}

	/**
	 * @param int $location
	 * @return self
	 */
	public function addLocation($location)
		{
		$this->locations[] = $location;

		return $this;
		}

	/**
	 * @return int
	 */
	public function getCustomer()
		{
		return $this->customer;
		}

	/**
	 * @param int $customer
	 * @return self
	 */
	public function setCustomer($customer)
		{
		$this->customer = $customer;

		return $this;
		}
	}
