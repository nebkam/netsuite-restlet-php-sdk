<?php

namespace Infostud\NetSuiteSdk\Model\Contact;

use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\Serializer\Annotation\Groups;

class CreateContactResponse
	{
	/**
	 * @Enum({"ok", "error"})
	 * @var string
	 */
	private $result;
	/**
	 * @Groups("internalid")
	 * @var int|null
	 */
	private $contactId;

	/**
	 * @return string
	 */
	public function getResult()
		{
		return $this->result;
		}

	/**
	 * @param string $result
	 * @return self
	 */
	public function setResult($result)
		{
		$this->result = $result;

		return $this;
		}

	/**
	 * @return bool
	 */
	public function isSuccessful()
		{
		return $this->result === 'ok';
		}

	/**
	 * @return int|null
	 */
	public function getContactId()
		{
		return $this->contactId;
		}

	/**
	 * @param int|null $contactId
	 * @return self
	 */
	public function setContactId($contactId)
		{
		$this->contactId = $contactId;

		return $this;
		}
	}