<?php

namespace Core;

/**
 * Main controller to be extended.
 */
class Controller {
  protected $view;
  protected $request;
  protected $requestMethod;

  public function __construct() {
    $this->view = new View();
    $this->request = $_REQUEST;
    $this->requestMethod = $_SERVER["REQUEST_METHOD"];
  }

  /**
   * Assign values/variables to the view and renders the view.
   */
  public function renderView($view, $data = []) {
    foreach ($data as $key => $value) {
      $this->view->assign($key, $value);
    }

    if (!empty($this->request)) {
      $this->handleRequest();
    }

    $this->view->render($view);
  }

  /**
   * Handles any request (get, post, etc.) and assign values/variables to the view.
   */
  private function handleRequest() {
    $request['values']['method'] = $this->requestMethod;
    foreach ($this->request as $key => $value) {
      $request['values']['values'][$key] = $value;
    }
    $this->view->assign('request', $request['values']);
  }
}
