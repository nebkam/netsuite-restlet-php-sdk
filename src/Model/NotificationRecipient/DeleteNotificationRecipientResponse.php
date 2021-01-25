<?php

namespace Infostud\NetSuiteSdk\Model\NotificationRecipient;

use Doctrine\Common\Annotations\Annotation\Enum;

class DeleteNotificationRecipientResponse
	{
	/**
	 * @Enum({"ok", "error"})
	 * @var string
	 */
	private $result;

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
	}
