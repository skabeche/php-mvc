<?php

namespace Core;

/**
 * User sessions.
 * 
 * WARNING: It needs a better solution, it is only for demo purposes.
 */
class Session {

  /**
   * Starts a session.
   */
  public static function start(): void {
    session_start();
  }

  /**
   * Destroys a session.
   */
  public static function destroy(): void {
    session_start();
    $_SESSION = [];
    session_destroy();
  }

  /**
   * Creates logged session.
   */
  public static function create(): void {
    // $_SESSION["sessionId"] = bin2hex(random_bytes(24));
    $_SESSION['loggedIn'] = true;
  }
}
