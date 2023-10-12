<?php

namespace Core;

/**
 * View system.
 * 
 * It loads the variables and renders the view/template.
 */
class View {
  protected $data = [];

  public function assign($key, $value): void {
    $this->data[$key] = $value;
  }

  public function render($view): void {
    $viewPath = __DIR__. '/../App/Views/' . $view . '.php';
    if (file_exists($viewPath)) {
      $data = $this->data;
      include_once $viewPath;
    } else {
      throw new \Exception("View not found: {$view}");
    }
  }
}
