<?php
declare(strict_types=1);

namespace Rgasch\Collection;

use Illuminate\Support\Str;

/**
 * Wrapper for Laravel/Illuminate Collection class.
 *
 * @property \Rgasch\Collection\Collection $min
 * @property \Rgasch\Collection\Collection $max
 */
class Collection extends \Illuminate\Support\Collection
{
	/**
	 * Magic getter implementation.
     * If we attempt to retrieve a key which does exist, we throw an exception.
     * This helps to catch typos and other assorted stupid mistakes.
	 *
	 * @param mixed $key
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	public function __get(mixed $key): mixed
	{
		if (!array_key_exists($key, $this->items)) {
			throw new \InvalidArgumentException("Attempting to get non-existent item [$key] from collection");
		}

		return $this->items[$key] ?? null;
	}


	/**
	 * @param mixed $key
	 * @param mixed $value
	 * @return void
	 */
	public function __set(mixed $key, mixed $value): void
	{
		$this->items[$key] = $value;
	}


	/**
	 * Create a collection
	 *
	 * @param mixed $value
	 * @param bool $recursive
	 * @return Collection
	 */
	public static function create(mixed $value = null, bool $recursive = true): Collection
	{
		$collection = new static($value);
		if ($recursive) {
			$collection = $collection->recursive();
		}

		return $collection;
	}


	/**
	 * Convert a nested array/object structure to a recursive collection structure
	 *
     * @param array $excludeClasses classes which should not be converted to a Collection
	 * @return Collection
	 */
	public function recursive(array $excludeClasses=[]): Collection
	{
		return $this->map(function ($value) use ($excludeClasses) {
			if (is_array($value)) {
				return self::create($value)->recursive();
			} elseif (is_object($value)) {
                if ($excludeClasses) {
                    $classBase = basename(Str::replace('\\', '/', get_class($value)));
                    if (isset($excludeClasses[$classBase])) {
                        return $value;
                    }
                }

				return self::create($value)->recursive();
			}

			return $value;
		});
	}
}

