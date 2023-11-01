<?php

namespace Core;

use Core\Router;

/**
 * Helper and common functions used in the application.
 */
class Helpers {

  /**
   * Check if the current page is the frontpage.
   */
  public static function isFrontpage(): bool {
    $currentUrl = Router::getCurrentPath();
    if ($currentUrl == '/') {
      return true;
    }

    return false;
  }
}
