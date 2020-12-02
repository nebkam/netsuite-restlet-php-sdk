<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

interface SuiteQLItem
	{
	/**
	 * @return int
	 */
	public function getId();
	/**
	 * @return string
	 */
	public function getName();
	/**
	 * @return int|null
	 */
	public function getParentId();
	}
