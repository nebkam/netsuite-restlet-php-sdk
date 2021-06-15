<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class GetOldCrmPaymentsResponse
	{
	/**
	 * @SerializedName("paymentdata")
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
	public function setItems($items): self
		{
		$this->items = $items;

		return $this;
		}
	}
