<?php

namespace Infostud\NetSuiteSdk\Serializer;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * Augments NameConverterInterface with `*withClass` methods
 * to allow passing $class into a SerializedNameConverter
 */
interface NameClassConverterInterface extends NameConverterInterface
	{
	/**
	 * Converts a property name to its normalized value.
	 *
	 * @param string $propertyName
	 * @param string $class
	 * @return string
	 */
	public function normalizeWithClass($propertyName, $class);

	/**
	 * Converts a property name to its denormalized value.
	 *
	 * @param string $propertyName
	 * @param string $class
	 * @return string
	 */
	public function denormalizeWithClass($propertyName, $class);
	}
