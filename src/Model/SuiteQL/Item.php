<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Item implements SuiteQLItem
	{
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @SerializedName("fullname")
	 * @var string
	 */
	private $name;
	/**
	 * @SerializedName("custitem_item_old_erp_id")
	 * @var string|null
	 */
	private $oldErpId;

	/**
	 * @return int
	 */
	public function getId(): int
		{
		return $this->id;
		}

	/**
	 * @param int $id
	 * @return self
	 */
	public function setId(int $id): self
		{
		$this->id = $id;

		return $this;
		}

	/**
	 * @return string
	 */
	public function getName(): string
		{
		return $this->name;
		}

	/**
	 * @param string $name
	 * @return Item
	 */
	public function setName(string $name): Item
		{
		$this->name = $name;

		return $this;
		}

	/**
	 * @return string|null
	 */
	public function getOldErpId(): ?string
		{
		return $this->oldErpId;
		}

	/**
	 * @param string|null $oldErpId
	 * @return Item
	 */
	public function setOldErpId(?string $oldErpId): Item
		{
		$this->oldErpId = $oldErpId;

		return $this;
		}

	}
