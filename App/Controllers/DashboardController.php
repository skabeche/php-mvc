<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\UserModel;

class DashboardController extends Controller {
  public function index(): array {
    $output = [];
    $user = new UserModel();
    
    $output['users'] = $user->getAllUsers();

    return $output;
  }
}
