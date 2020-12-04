<?php

namespace Infostud\NetSuiteSdk\Serializer;

use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;

/**
 * Custom name converter that uses property AND class name to determine
 * what should the property be (de)normalized to.
 * Uses `Groups` annotation instead of `SerializedName` (that was added
 * in later Symfony versions).
 * Because of that, using `Groups` for context groups
 * can lead to unexpected results and should be avoided at all cost.
 */
class GroupsNameConverter implements ClassAwareNameConverterInterface
	{
	private static $normalizeCache = [];
	private static $denormalizeCache = [];
	private static $attributesMetadataCache = [];
	/**
	 * @var ClassMetadataFactory
	 */
	private $metadataFactory;

	/**
	 * @param ClassMetadataFactory $classMetadataFactory
	 */
	public function __construct($classMetadataFactory)
		{
		$this->metadataFactory = $classMetadataFactory;
		}

	/**
	 * @inheritDoc
	 */
	public function normalizeWithClass($propertyName, $class)
		{
		// TODO: Implement normalizeWithClass() method.
		return $propertyName;
		}

	/**
	 * @inheritDoc
	 */
	public function denormalizeWithClass($propertyName, $class)
		{
		if (!array_key_exists($class, self::$denormalizeCache)
			|| !array_key_exists($propertyName, self::$denormalizeCache[$class]))
			{
			self::$denormalizeCache[$class][$propertyName] = $this->getCacheValueForDenormalization($propertyName, $class);
			}

		if (self::$denormalizeCache[$class][$propertyName])
			{
			return self::$denormalizeCache[$class][$propertyName];
			}

		return $propertyName;
		}

	/**
	 * Unused stub
	 * @param string $propertyName
	 * @return string
	 */
	public function normalize($propertyName)
		{
		return $propertyName;
		}

	/**
	 * Unused stub
	 * @param string $propertyName
	 * @return string
	 */
	public function denormalize($propertyName)
		{
		return $propertyName;
		}

	private function getCacheValueForDenormalization($propertyName, $class)
		{
		if (!array_key_exists($class, self::$attributesMetadataCache))
			{
			self::$attributesMetadataCache[$class] = $this->getCacheValueForAttributesMetadata($class);
			}

		return isset(self::$attributesMetadataCache[$class][$propertyName])
			? self::$attributesMetadataCache[$class][$propertyName]
			: null;
		}

	private function getCacheValueForAttributesMetadata($class)
		{
		if (!$this->metadataFactory->hasMetadataFor($class))
			{
			return [];
			}

		$classMetadata = $this->metadataFactory->getMetadataFor($class);

		$cache = [];
		foreach ($classMetadata->getAttributesMetadata() as $name => $metadata)
			{
			if (empty($metadata->getGroups()))
				{
				continue;
				}

			// First group instead of $metadata->getSerializedName()
			$serializedName         = $metadata->getGroups()[0];
			$cache[$serializedName] = $name;
			}

		return $cache;
		}
	}
