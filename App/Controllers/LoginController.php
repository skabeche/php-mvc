<?php

namespace App\Controllers;

use Core\Controller;
use Core\Message;
use Core\Session;
use App\Models\UserModel;

class LoginController extends Controller {

  public function index(): array {
    $output = [];

    if ($this->requestMethod === 'POST') {
      $session = new Session;
      $session::create();
      header('Location: /dashboard');
      exit;
    }

    return $output;
  }
}
