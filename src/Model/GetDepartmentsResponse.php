<?php

namespace Infostud\NetSuiteSdk\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class GetDepartmentsResponse
	{
	/**
	 * @SerializedName("rows")
	 * @var Department[]
	 */
	private $departments;

	/**
	 * @return Department[]
	 */
	public function getDepartments(): array
		{
		return $this->departments;
		}

	/**
	 * @param Department[] $departments
	 * @return self
	 */
	public function setDepartments(array $departments): self
		{
		$this->departments = $departments;

		return $this;
		}
	}
