<?php

namespace Core;

/**
 * Helper and common functions used in the application.
 */
class Helpers {

  /**
   * Check if the current page is the frontpage.
   */
  function isFrontpage(): bool {
    $current_url = $_SERVER['REQUEST_URI'];
    if ($current_url == '/') {
      return true;
    }

    return false;
  }
}
