<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\Groups;

class ItemSearchResponse
	{
	/**
	 * @Groups("myPagedData")
	 * @var SearchMetadata
	 */
	private $searchMetadata;
	/**
	 * @var Item[]
	 */
	private $items;

	/**
	 * @return SearchMetadata
	 */
	public function getSearchMetadata()
		{
		return $this->searchMetadata;
		}

	/**
	 * @param SearchMetadata $searchMetadata
	 * @return ItemSearchResponse
	 */
	public function setSearchMetadata($searchMetadata)
		{
		$this->searchMetadata = $searchMetadata;

		return $this;
		}

	/**
	 * @return Item[]
	 */
	public function getItems()
		{
		return $this->items;
		}

	/**
	 * @param Item[] $items
	 * @return self
	 */
	public function setItems($items)
		{
		$this->items = $items;

		return $this;
		}
	}
