<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class NotificationRecipientAttributes
	{
	/**
	 * @Groups("custrecord_rsm_custnp_location")
	 * @var IdNameTuple[]
	 */
	private $location;
	/**
	 * @Groups("custrecord_rsm_custnp_description")
	 * @var string
	 */
	private $description;
	/**
	 * @Groups("custrecord_rsm_custnp_mailto")
	 * @var string
	 */
	private $mailTo;
	/**
	 * @Groups("custrecord_rsm_custnp_mailcc")
	 * @var string
	 */
	private $mailCc;

	/**
	 * @return IdNameTuple[]
	 */
	public function getLocation()
		{
		return $this->location;
		}

	/**
	 * @param IdNameTuple[] $location
	 */
	public function setLocation($location)
		{
		$this->location = $location;
		}

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
	public function getMailTo()
		{
		return explode(';',$this->mailTo);
		}

	/**
	 * @param array $mailTo
	 */
	public function setMailTo($mailTo)
		{
		$this->mailTo = implode(';',$mailTo);
		}

	/**
	 * @return array
	 */
	public function getMailCc()
		{
		return explode(';',$this->mailCc);
		}

	/**
	 * @param array $mailCc
	 */
	public function setMailCc($mailCc)
		{
		$this->mailCc = implode(';',$mailCc);
		}
	}
