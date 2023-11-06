<?php

namespace App\Controllers;

use Core\Controller;
use Core\Message;
use Core\Session;
use Core\Request;
use Core\Utils\Validation;
use App\Models\UserModel;

class LoginController extends Controller {

  public function index(): array {
    $output = [];

    // do something.

    return $output;
  }

  public function login(): void {
    $request = new Request();
    $validation = new Validation();

    // Validate input.
    $fields = [
      'email' => 'required|email',
      'password' => 'required',
    ];
    if (!$validation->validate($request->httpData, $fields)) {
      Message::set($validation->getErrors(), 'error');
      return;
    }

    // If pass validation, check stored credentials.
    $user = new UserModel();
    $userData = $user->getUserByEmail($request->getHttpData()['email']);
    // If the user does not exist.
    if (!$userData) {
      Message::set('Sorry, email or password are not recognised. Check your credentials and try again.', 'error');
      return;
    }

    // Check if the password is correct.
    if (password_verify($request->getHttpData()['password'], $userData['password'])) {
      Message::set('You are logged in.');
      $session = new Session;
      $session::create();

      header('Location: /dashboard');
      exit;
    } else {
      Message::set('Sorry, email or password are not recognised. Check your credentials and try again.', 'error');
    }

    return;
  }
}
