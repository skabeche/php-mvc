<?php

namespace App\Controllers;

use Core\Controller;
use Core\Session;

class LogoutController extends Controller {
  public function destroy(): array {
    $session = new Session();
    $session::destroy();
    header('Location: /');
    exit;
  }
}
