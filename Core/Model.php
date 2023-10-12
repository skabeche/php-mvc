<?php

namespace Core;

use Core\Connection;

/**
 * Main model to be extended.
 */
class Model {
  protected $db;

  public function __construct() {
    $this->db = Connection::getInstance();
  }

  protected function query($query, $params = []) {
    $stmt = $this->db->prepare($query);
    $stmt->execute($params);

    return $stmt;
  }
}
