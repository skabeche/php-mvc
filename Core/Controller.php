<?php

namespace Core;

/**
 * Main controller to be extended.
 */
class Controller {
  protected $view;

  public function __construct() {
    $this->view = new View();
  }

  /**
   * Assign values/variables to the view and renders the view.
   */
  public function renderView(string $view, array $data = []): string {
    foreach ($data as $key => $value) {
      $this->view->assign($key, $value);
    }

    return $this->view->render($view);
  }
}
