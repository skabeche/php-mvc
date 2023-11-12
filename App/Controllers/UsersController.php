<?php

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use App\Models\UserModel;

class UsersController extends Controller {

  private $user;

  public function __construct() {
    $this->user = new UserModel();
  }

  public function index(): array {
    $output = [];

    return $output;
  }

  public function show(): array {
    $request = new Request();
    $output = [];
    $id = $request->getBody()['id'];

    $output['user'] = $this->user->getUserById((int) $id);

    return $output;
  }
}
