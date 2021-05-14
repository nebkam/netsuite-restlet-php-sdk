<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class GetPaymentsResponse
	{
	/**
	 * @Groups("paymentdata")
	 * @var PaymentItem[]
	 */
	private $items;

	/**
	 * @return PaymentItem[]
	 */
	public function getItems()
		{
		return $this->items;
		}

	/**
	 * @param PaymentItem[] $items
	 * @return self
	 */
	public function setItems($items)
		{
		$this->items = $items;

		return $this;
		}
	}
