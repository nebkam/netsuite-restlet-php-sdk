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
	public function getDepartments()
		{
		return $this->departments;
		}

	/**
	 * @param Department[] $departments
	 * @return self
	 */
	public function setDepartments($departments)
		{
		$this->departments = $departments;

		return $this;
		}
	}
