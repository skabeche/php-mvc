<?php

namespace Core;

use Core\Connection;
use PDO;

/**
 * Main model to be extended.
 * 
 * @todo Bind values.
 */
class Model {
  protected $db;

  public function __construct() {
    $this->db = Connection::getInstance();
  }

  protected function query(string $query, array $params = []): mixed {
    $stmt = $this->db->prepare($query);
    $stmt->execute($params);

    return $stmt;
  }

    /**
   * Find a row in a table by column and value.
   * 
   * @param array $table
   * @param int $column
   * @param int|string $value
   *
   * @return array
   */
  public function fetch(string $table, string $column, int|string $value): array|bool {
    $query = is_int($value) ? "SELECT * FROM {$table} WHERE {$column}={$value}" : "SELECT * FROM {$table} WHERE {$column}='{$value}'";
    $stmt = $this->query($query);

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
