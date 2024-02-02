<?php

namespace Core;

use Core\Utils\Sanitizer;

class Request {

  private $method;
  private static $params = [];
  private $queryString;

  public function __construct() {
    // Get method.
    $method = strtolower($_SERVER["REQUEST_METHOD"]);
    $this->method = $method;
    // Get params according to method.
    self::$params += method_exists($this, $method) ? $this->$method() : [];
    // Get query string from URL.
    parse_str($_SERVER['QUERY_STRING'], $params);
    $this->queryString = Sanitizer::sanitize($params);
  }

  public function getMethod(): string {
    return $this->method;
  }

  public function getQueryString(): array {
    return $this->queryString;
  }

  public function getBody(): array {
    return self::$params;
  }

  public function setParam(string $key, string $value) {
    self::$params[$key] = $value;
  }

  public function get() {
    return Sanitizer::sanitize($_GET);
  }

  public function post() {
    return Sanitizer::sanitize($_POST);
  }
}
