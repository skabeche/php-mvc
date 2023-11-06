<?php

namespace Core\Utils;

use Core\Connection;

/**
 * Class to validate input.
 * 
 * @see https://www.phptutorial.net/php-tutorial/php-validation/
 */
const DEFAULT_VALIDATION_ERRORS = [
  'required' => 'Please enter the %s.',
  'email' => 'The %s is not a valid email address.',
  'min' => 'The %s must have at least %s characters.',
  'max' => 'The %s must have at most %s characters.',
  'between' => 'The %s must have between %d and %d characters.',
  'same' => 'The %s must match with %s.',
  'alphanumeric' => 'The %s should have only letters and numbers.',
  'secure' => 'The %s must have between 8 and 64 characters and contain at least one number, one upper case letter, one lower case letter and one special character.',
  'unique' => 'The %s already exists.',
];

class Validation {

  protected $db;
  protected $errors = [];

  public function __construct() {
    $this->db = Connection::getInstance();
  }

  /**
   * Validate input.
   * 
   * @param array $data
   * @param array $fields
   * e.g.
   * $fields = [
   *    'firstname' => 'required, max:255',
   *    'lastname' => 'required, max: 255',
   *    'address' => 'required | min: 10, max:255',
   *    'zipcode' => 'between: 5,6',
   *    'username' => 'required | alphanumeric | between: 3,255 | unique: users,username',
   *    'email' => 'required | email | unique: users,email',
   *    'password' => 'required | secure',
   *    'password2' => 'required | same:password'
   *  ];
   * @param array $messages
   * 
   * @return array
   */
  public function validate(array $data, array $fields, array $messages = []): bool {
    // Split the array by a separator, trim each element and return the array.
    $split = fn ($str, $separator) => array_map('trim', explode($separator, $str));

    // Get the message rules.
    $ruleMessages = array_filter($messages, fn ($message) => is_string($message));
    // Overwrite the default message.
    $validationErrors = array_merge(DEFAULT_VALIDATION_ERRORS, $ruleMessages);

    foreach ($fields as $field => $option) {

      $rules = $split($option, '|');

      foreach ($rules as $rule) {
        // Get rule name params.
        $params = [];
        // If the rule has parameters e.g., min: 1
        if (strpos($rule, ':')) {
          [$rule_name, $param_str] = $split($rule, ':');
          $params = $split($param_str, ',');
        } else {
          $rule_name = trim($rule);
        }
        // By convention, the callback should be is<Rule>
        // e.g. isRequired
        $fn = 'is' . ucwords($rule_name);

        if (method_exists($this, $fn)) {
          $pass = $this->$fn($data, $field, ...$params);
          if (!$pass) {
            // Get the error message for a specific field and rule if exists.
            // Otherwise get the error message from the $validationErrors.
            $this->errors[$field] = sprintf(
              $messages[$field][$rule_name] ?? $validationErrors[$rule_name],
              $field,
              ...$params
            );
          }
        }
      }
    }

    return empty($this->getErrors()) ? true : false;
  }

  /**
   * Return errors message.
   * 
   * @return array
   */
  public function getErrors(): array {
    return $this->errors;
  }

  /**
   * Return true if a string is not empty.
   * @param array $data
   * @param string $field
   * 
   * @return bool
   */
  public function isRequired(array $data, string $field): bool {
    return isset($data[$field]) && trim($data[$field]) !== '';
  }

  /**
   * Return true if the value is a valid email.
   * 
   * @param array $data
   * @param string $field
   * 
   * @return bool
   */
  public function isEmail(array $data, string $field): bool {
    if (empty($data[$field])) {
      return true;
    }

    return filter_var($data[$field], FILTER_VALIDATE_EMAIL);
  }

  /**
   * Return true if a string has at least min length.
   * 
   * @param array $data
   * @param string $field
   * @param int $min
   * 
   * @return bool
   */
  public function isMin(array $data, string $field, int $min): bool {
    if (!isset($data[$field])) {
      return true;
    }

    return mb_strlen($data[$field]) >= $min;
  }

  /**
   * Return true if a string cannot exceed max length.
   * 
   * @param array $data
   * @param string $field
   * @param int $max
   * 
   * @return bool
   */
  public function isMax(array $data, string $field, int $max): bool {
    if (!isset($data[$field])) {
      return true;
    }

    return mb_strlen($data[$field]) <= $max;
  }

  /**
   * Return true if a string is in a range.
   * 
   * @param array $data
   * @param string $field
   * @param int $min
   * @param int $max
   * 
   * @return bool
   */
  public function isBetween(array $data, string $field, int $min, int $max): bool {
    if (!isset($data[$field])) {
      return true;
    }

    $len = mb_strlen($data[$field]);
    return $len >= $min && $len <= $max;
  }

  /**
   * Return true if a string equals the other.
   * 
   * @param array $data
   * @param string $field
   * @param string $other
   * 
   * @return bool
   */
  public function isSame(array $data, string $field, string $other): bool {
    if (isset($data[$field], $data[$other])) {
      return $data[$field] === $data[$other];
    }

    if (!isset($data[$field]) && !isset($data[$other])) {
      return true;
    }

    return false;
  }

  /**
   * Return true if a string is alphanumeric.
   * 
   * @param array $data
   * @param string $field
   * 
   * @return bool
   */
  public function isAlphanumeric(array $data, string $field): bool {
    if (!isset($data[$field])) {
      return true;
    }

    return ctype_alnum($data[$field]);
  }

  /**
   * Return true if a password is secure.
   * 
   * @param array $data
   * @param string $field
   * 
   * @return bool
   */
  public function isSecure(array $data, string $field): bool {
    if (!isset($data[$field])) {
      return false;
    }

    $pattern = "#.*^(?=.{8,64})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#";
    return preg_match($pattern, $data[$field]);
  }

  /**
   * Return true if the $value is unique in the column of a table.
   * 
   * @param array $data
   * @param string $field
   * @param string $table
   * @param string $column
   * 
   * @return bool
   */
  public function isUnique(array $data, string $field, string $table, string $column): bool {
    if (!isset($data[$field])) {
      return true;
    }

    $sql = "SELECT {$column} FROM {$table} WHERE {$column} = :value";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":value", $data[$field]);

    $stmt->execute();

    return $stmt->fetchColumn() === false;
  }
}
