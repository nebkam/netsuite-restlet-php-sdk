<?php

namespace Infostud\NetSuiteSdk\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class GetSubsidiariesResponse
	{
	/**
	 * @SerializedName("rows")
	 * @var Subsidiary[]
	 */
	private $subsidiaries;

	/**
	 * @return Subsidiary[]
	 */
	public function getSubsidiaries(): array
		{
		return $this->subsidiaries;
		}

	/**
	 * @param Subsidiary[] $subsidiaries
	 * @return self
	 */
	public function setSubsidiaries(array $subsidiaries): self
		{
		$this->subsidiaries = $subsidiaries;

		return $this;
		}
	}
