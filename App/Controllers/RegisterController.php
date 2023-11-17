<?php

namespace App\Controllers;

use Core\Controller;
use Core\Message;
use Core\Request;
use Core\Utils\Validation;
use App\Models\UserModel;

class RegisterController extends Controller {

  public function index(): array {

    // do something.

    return [];
  }

  public function store(): void {
    $request = new Request();
    $validation = new Validation();

    // Validate input.
    $fields = [
      'name' => 'required,max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required',
      'password2' => 'required|same:password'
    ];
    if (!$validation->validate($request->getBody(), $fields, ['password2' => ['same' => 'Password fields does not match.']])) {
      Message::set($validation->getErrors(), 'error');
      return;
    }

    // If pass validation, create user.
    $user = new UserModel();
    $userCreated = $user->create($request->getBody());
    if ($userCreated) {
      Message::set('Thanks for registering.');
      return;
    }

    // Default message if anything else fails.
    Message::set('There was a problem registering your user, try again.', 'error');

    return;
  }
}
