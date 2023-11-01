<?php

namespace Core;

/**
 * Utils to be used in the application.
 */
class Utils {

  /**
   * PHP's array_column implementation that works on multidimensional arrays (not just 2-dimensional).
   * 
   * @see https://github.com/NinoSkopac/array_column_recursive
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

  /**
   * Functions to sanitize input.
   * 
   * @see https://www.phptutorial.net/php-tutorial/php-sanitize-input
   */
  const FILTERS = [
    'string' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'string[]' => [
      'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
      'flags' => FILTER_REQUIRE_ARRAY
    ],
    'email' => FILTER_SANITIZE_EMAIL,
    'int' => [
      'filter' => FILTER_SANITIZE_NUMBER_INT,
      'flags' => FILTER_REQUIRE_SCALAR
    ],
    'int[]' => [
      'filter' => FILTER_SANITIZE_NUMBER_INT,
      'flags' => FILTER_REQUIRE_ARRAY
    ],
    'float' => [
      'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
      'flags' => FILTER_FLAG_ALLOW_FRACTION
    ],
    'float[]' => [
      'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
      'flags' => FILTER_REQUIRE_ARRAY
    ],
    'url' => FILTER_SANITIZE_URL,
  ];

  /**
   * Recursively trim strings in an array
   * 
   * @param array $items
   * 
   * @return array
   */
  public static function arrayTrim(array $items): array {
    return array_map(function ($item) {
      if (is_string($item)) {
        return trim($item);
      } elseif (is_array($item)) {
        return self::arrayTrim($item);
      } else
        return $item;
    }, $items);
  }

  /**
   * Sanitize the inputs based on the rules an optionally trim the string
   * 
   * @param array $inputs
   * @param array $fields
   * @param int $default_filter FILTER_SANITIZE_FULL_SPECIAL_CHARS
   * @param array $filters FILTERS
   * @param bool $trim
   * 
   * @return array
   */
  public static function sanitize(
    array $inputs,
    array $fields = [],
    int $default_filter = FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    array $filters = self::FILTERS,
    bool $trim = true
  ): array {
    if ($fields) {
      $options = array_map(fn ($field) => $filters[$field], $fields);
      $data = filter_var_array($inputs, $options);
    } else {
      $data = filter_var_array($inputs, $default_filter);
    }

    return $trim ? self::arrayTrim($data) : $data;
  }
}
