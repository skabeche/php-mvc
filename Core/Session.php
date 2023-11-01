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
   * 
   */
  public static function create(): void {
    // $_SESSION["sessionId"] = bin2hex(random_bytes(24));
    $_SESSION["loggedIn"] = true;
  }

  /**
   * Check if the user is authenticated.
   * 
   * TODO: a better and more solid check, it is only for demo purposes.
   */
  public static function isLoggedIn(): bool {
    if ($_SESSION["loggedIn"] == true) {
      return true;
    }

    return false;
  }

  /**
   * Check if user with a specific role has access to the resource.
   * - guest
   * - auth
   * 
   * @param string $role
   *   Access role to check.
   */
  public static function hasAccessByRole(string $role): bool {
    if ($role == 'auth') {
      if (!self::isLoggedIn()) {
        return false;
      }
    }

    return true;
  }
}
