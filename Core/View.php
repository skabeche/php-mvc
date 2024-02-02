<?php

namespace Core;

/**
 * View system.
 * 
 * It loads the variables and renders the view/template.
 */
class View {
  private $data = [];

  public function assign(string $key, string|array $value): void {
    $this->data[$key] = $value;
  }

  public function render(string $view): void {
    $themePath = __DIR__ . '/../public/dist';
    $loader = new \Twig\Loader\FilesystemLoader($themePath);
    $twig = new \Twig\Environment($loader, ['debug' => true]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
    $twig->display('/views/' . $view . '.html', $this->data);
  }
}
