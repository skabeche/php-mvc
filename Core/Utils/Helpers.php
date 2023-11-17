<?php

namespace Core\Utils;

use Core\Router;

/**
 * Helper and common functions used in the application.
 */
class Helpers {

  /**
   * Check if the current page is the frontpage.
   */
  public static function isFrontpage(): bool {
    $router = new Router();
    if ($router->getCurrentPath() == '/') {
      return true;
    }

    return false;
  }
}
