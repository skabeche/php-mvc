<?php

namespace App\Models;

use Core\Model;
use PDO;

class UserModel extends Model {

  /**
   * Get all users.
   *
   * @return array
   */
  public function getAllUsers(): array {
    $query = "SELECT * FROM users";
    $stmt = $this->query($query);

    // Fetch the results as an associative array.
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $users;
  }

  /**
   * Get an user by ID.
   * 
   * @param int $id
   *
   * @return array
   */
  public function getUserById(int $id): array {
    $query = "SELECT * FROM users WHERE id={$id}";
    $stmt = $this->query($query);

    // Fetch the results as an associative array
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $user;
  }

  /**
   * Get an user by email.
   * 
   * @param string $email
   *
   * @return array
   */
  public function getUserByEmail(string $email): array {
    $query = "SELECT * FROM users WHERE email='{$email}'";
    $stmt = $this->query($query);

    // Fetch the results as an associative array
    $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $user;
  }
}
