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
	public function getRows(): array
		{
		return $this->rows;
		}

	/**
	 * @param NotificationRecipient[] $rows
	 * @return self
	 */
	public function setRows(array $rows): self
		{
		$this->rows = $rows;

		return $this;
		}
	}
