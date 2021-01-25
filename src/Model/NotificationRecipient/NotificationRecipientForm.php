<?php

namespace Infostud\NetSuiteSdk\Model\NotificationRecipient;

use Infostud\NetSuiteSdk\Exception\ApiLogicException;
use Symfony\Component\Serializer\Annotation\Groups;

class NotificationRecipientForm
	{
	/**
	 * @var string
	 */
	private $description;
	/**
	 * @var string
	 */
	private $emailTo;
	/**
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
	 */
	public function setDescription($description)
		{
		$this->description = $description;
		}

	/**
	 * @return array
	 */
	public function getEmailTo()
		{
		return explode(';',$this->emailTo);
		}

	/**
	 * @param array $emailTo
	 */
	public function setEmailTo($emailTo)
		{
		$this->emailTo = implode(';',$emailTo);
		}

	/**
	 * @return array
	 */
	public function getEmailCc()
		{
		return explode(';',$this->emailCc);
		}

	/**
	 * @param array $emailCc
	 */
	public function setEmailCc($emailCc)
		{
		$this->emailCc = implode(';',$emailCc);
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
	 */
	public function setLocations($locations)
		{
		$this->locations = $locations;
		}

	/**
	 * @param int $location
	 */
	public function addLocation($location)
		{
		$this->locations[] = $location;
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
	 */
	public function setCustomer($customer)
		{
		$this->customer = $customer;
		}

	}