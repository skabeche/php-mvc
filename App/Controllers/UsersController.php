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

    $output['users'] = $this->user->getAllUsers();

    return $output;
  }
}
