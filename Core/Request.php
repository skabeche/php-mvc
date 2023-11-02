<?php

namespace Core;

use Core\Utils;

class Request {

  public $httpMethod;
  public $httpData;
  public $queryString;

  public function __construct() {
    $this->httpMethod = strtolower($_SERVER["REQUEST_METHOD"]);
    $this->httpData = Utils::sanitize($_REQUEST);
    parse_str($_SERVER['QUERY_STRING'], $params);
    $this->queryString = Utils::sanitize($params);
  }

  public function getHttpMethod(): string {
    return $this->httpMethod;
  }

  public function getHttpData(): array {
    return $this->httpData;
  }

  public function getQueryString(): array {
    return $this->queryString;
  }
}