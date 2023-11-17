<?php

namespace App\Controllers;

use Core\Controller;
use Core\Message;
use Core\Request;
use Core\Utils\Validation;
use App\Models\UserModel;

class UserController extends Controller {

  private $user;
  private $request;

  public function __construct() {
    $this->user = new UserModel();
    $this->request = new Request();
  }

  public function index(): array {
    $output = [];

    if (isset($this->request->getBody()['id'])) {
      $id = $this->request->getBody()['id'];
      $output['user'] = $this->user->getUserById((int) $id);
    }

    return $output;
  }

  public function create(): void {
    $validation = new Validation();

    // Validate input.
    $fields = [
      'name' => 'required,max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required',
      'password2' => 'required|same:password'
    ];
    if (!$validation->validate($this->request->getBody(), $fields, ['password2' => ['same' => 'Password fields does not match.']])) {
      Message::set($validation->getErrors(), 'error');
      return;
    }

    // If pass validation, create user.
    $userCreated = $this->user->create($this->request->getBody());
    if ($userCreated) {
      Message::set("User {$this->request->getBody()['email']} has been created.");
      header('Location: /users');
      exit;
    }

    // Default message if anything else fails.
    Message::set('There was a problem creating the user, try again.', 'error');

    return;
  }

  public function edit(): array {
    $output = [];
    $validation = new Validation();
    $id = $this->request->getBody()['id'];

    // Redirect to delete the user if that is the case.
    if (isset($this->request->getBody()['delete'])) {
      header("Location: /users/{$id}/delete");
      exit;
    }

    $output['user'] = $this->user->getUserById((int) $id);
    // Validate input.
    $fields = [
      'name' => 'required,max:255',
      'email' => 'required|email',
    ];
    if (!$validation->validate($this->request->getBody(), $fields)) {
      Message::set($validation->getErrors(), 'error');
      return $output;
    }

    // Update user.
    $userUpdated = $this->user->update($this->request->getBody());
    if ($userUpdated) {
      Message::set("User {$this->request->getBody()['email']} has been updated.");
      header('Location: /users');
      exit;
    }

    // Default message.
    Message::set('There was a problem updating the user, try again.', 'error');
    return $output;
  }

  public function delete(): void {
    $id = $this->request->getBody()['id'];
    $userDeleted  = $this->user->delete((int) $id);

    if ($userDeleted) {
      Message::set('User has been deleted.');
      header('Location: /users');
      exit;
    }

    // Default message.
    Message::set('There was a problem deleting the user, try again.', 'error');
    return;
  }
}
