<?php

namespace Core;

class Auth {

  /**
   * Check if the user is authenticated.
   * 
   * TODO: a better and more solid check, it is only for demo purposes.
   */
  public static function isLoggedIn(): bool {
    if ($_SESSION['loggedIn'] === true) {
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
   * 
   * @return bool
   */
  public static function hasAccessByRole(string $role): bool {
    if ($role === 'auth') {
      if (!self::isLoggedIn()) {
        return false;
      }
    }

    return true;
  }
}
