<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class GetOldCrmPaymentsResponse
	{
	/**
	 * @Groups("paymentdata")
	 * @var OldCrmPaymentItem[]
	 */
	private $items;

	/**
	 * @return OldCrmPaymentItem[]
	 */
	public function getItems()
		{
		return $this->items;
		}

	/**
	 * @param OldCrmPaymentItem[] $items
	 * @return self
	 */
	public function setItems($items)
		{
		$this->items = $items;

		return $this;
		}
	}
