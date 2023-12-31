<?php

namespace Core;

/**
 * Message system.
 */
class Message {

  /**
   * Sets a message to display on the site.
   *
   * @param string|array $message
   *   (optional) The message to be displayed on the site.
   * @param string $type
   *   (optional) The type of message. Defaults to 'success'.
   *   - 'success'
   *   - 'error'
   *   - 'warning'
   */
  public static function set(string|array $message = NULL, string $type = 'success'): void {
    if ($message) {
      if (is_array($message)) {
        array_walk($message, fn (&$value, $key) => $value = "{$value}");
        $_SESSION['message']['text'] = implode("<br/>", $message);
      } else {
        $_SESSION['message']['text'] = $message;
      }
      $_SESSION['message']['type'] = $type;
    }
  }

  /**
   * Returns the message to be displayed.
   * 
   * @return array
   */
  public static function get(): array {
    $output = [];

    if (isset($_SESSION['message'])) {
      $output = $_SESSION['message'];
      unset($_SESSION['message']);
    }

    return $output;
  }
}
