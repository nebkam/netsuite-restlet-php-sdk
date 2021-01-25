<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

class NotificationRecipientSearchResponse implements GenericSavedSearchResponse
	{
	/**
	 * @var NotificationRecipient[]
	 */
	private $rows;

	/**
	 * @return NotificationRecipient[]
	 */
	public function getRows()
		{
		return $this->rows;
		}

	/**
	 * @param NotificationRecipient[] $rows
	 * @return self
	 */
	public function setRows($rows)
		{
		$this->rows = $rows;

		return $this;
		}
	}
