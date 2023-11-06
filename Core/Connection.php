<?php

namespace Core;

use PDO;
use PDOException;

/**
 * DB connection.
 * 
 * @todo Bind values.
 */
class Connection {
  private static $instance = null;
  private $conn;

  private function __construct() {
    $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']}";
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $options = array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // By default in PHP 8.
    );

    try {
      $this->conn = new PDO($dsn, $user, $password, $options);
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }

  public static function getInstance() {
    if (!self::$instance) {
      self::$instance = new self();
    }

    return self::$instance->getConnection();
  }

  public function getConnection() {
    return $this->conn;
  }
}
