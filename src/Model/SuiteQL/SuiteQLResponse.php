<?php

namespace Infostud\NetSuiteSdk\Model\SuiteQL;

interface SuiteQLResponse
	{
	/**
	 * @return SuiteQLItem[]
	 */
	public function getRows();
	}
