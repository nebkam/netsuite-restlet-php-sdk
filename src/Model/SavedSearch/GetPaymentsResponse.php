<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class GetPaymentsResponse
	{
	/**
	 * @SerializedName("paymentdata")
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
	public function setItems($items): self
		{
		$this->items = $items;

		return $this;
		}
	}
