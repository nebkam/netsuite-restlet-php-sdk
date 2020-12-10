<?php

namespace Infostud\NetSuiteSdk\Model\Customer;

use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\Serializer\Annotation\Groups;

class CreateCustomerResponse
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
	private $customerId;

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
	public function getCustomerId()
		{
		return $this->customerId;
		}

	/**
	 * @param int|null $customerId
	 * @return self
	 */
	public function setCustomerId($customerId)
		{
		$this->customerId = $customerId;

		return $this;
		}
	}
