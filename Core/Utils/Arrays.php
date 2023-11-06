<?php

namespace Core\Utils;

/**
 * Array tools libray.
 */
class Arrays {

  /**
   * PHP's array_column implementation that works on multidimensional arrays (not just 2-dimensional).
   * 
   * @see https://github.com/NinoSkopac/array_column_recursive
   * 
   * @return array
   */
  public static function arrayColumnRecursive(array $haystack, string $needle): array {
    $found = [];
    array_walk_recursive($haystack, function ($value, $key) use (&$found, $needle) {
      if ($key == $needle)
        $found[] = $value;
    });

    return $found;
  }

  /**
   * Groups an array of associative arrays by key.
   * 
   * @param string $key
   *  Key to group by.
   * @param array $data
   *  Array that contains multiple associative arrays.
   * 
   * @return array
   */
  public static function arrayAssocGroupBy(string $key, array $data): array {
    $result = [];

    foreach ($data as $value) {
      if (array_key_exists($key, $value)) {
        $result[$value[$key]][] = $value;
      } else {
        $result[''][] = $value;
      }
    }

    return $result;
  }
}
