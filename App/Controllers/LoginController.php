<?php

namespace App\Controllers;

use Core\Controller;
use Core\Message;
use Core\Session;
use App\Models\UserModel;

class LoginController extends Controller {

  public function index(): array {
    $output = [];

    // do something.

    return $output;
  }

  public function login(): void {
    $session = new Session;
    $session::create();
    Message::set('You are now logged in');
    header('Location: /dashboard');
    exit;
  }
}
