<?php

namespace Infostud\NetSuiteSdk\Model\SalesOrder;

use Symfony\Component\Serializer\Annotation\Groups;

class CreateSalesOrderResponse
	{
	/**
	 * @var string
	 */
	private $result;
	/**
	 * @Groups("internalid")
	 * @var int|null
	 */
	private $orderId;
	/**
	 * @var string|null
	 */
	private $errorName;
	/**
	 * @Groups("message")
	 * @var string|null
	 */
	private $errorMessage;

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
	public function getOrderId()
		{
		return $this->orderId;
		}

	/**
	 * @param int|null $orderId
	 * @return self
	 */
	public function setOrderId($orderId)
		{
		$this->orderId = $orderId;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getErrorName()
		{
		return $this->errorName;
		}

	/**
	 * @param string|null $errorName
	 * @return self
	 */
	public function setErrorName($errorName)
		{
		$this->errorName = $errorName;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getErrorMessage()
		{
		return $this->errorMessage;
		}

	/**
	 * @param string|null $errorMessage
	 * @return self
	 */
	public function setErrorMessage($errorMessage)
		{
		$this->errorMessage = $errorMessage;

		return $this;
		}
	}
