<?php

namespace App\Controllers;

use Core\Controller;
use Core\Session;

class LogoutController extends Controller {
  public function index(): array {
    $session = new Session();
    $session::destroy();
    header('Location: /');
    exit;
  }
}
