<?php

namespace Infostud\NetSuiteSdk\Model\SavedSearch;

use Symfony\Component\Serializer\Annotation\SerializedName;

class ItemSearchResponse
	{
	/**
	 * @SerializedName("myPagedData")
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
	public function getSearchMetadata(): SearchMetadata
		{
		return $this->searchMetadata;
		}

	/**
	 * @param SearchMetadata $searchMetadata
	 * @return self
	 */
	public function setSearchMetadata(SearchMetadata $searchMetadata): self
		{
		$this->searchMetadata = $searchMetadata;

		return $this;
		}

	/**
	 * @return Item[]
	 */
	public function getItems(): array
		{
		return $this->items;
		}

	/**
	 * @param Item[] $items
	 * @return self
	 */
	public function setItems(array $items): self
		{
		$this->items = $items;

		return $this;
		}
	}
