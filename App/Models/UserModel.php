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

    // Fetch all results as an associative array.
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
  public function getUserById(int $id): array|bool {
    $query = "SELECT * FROM users WHERE id={$id}";
    $stmt = $this->query($query);

    // Fetch the result as an associative array.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
  }

  /**
   * Get an user by email.
   * 
   * @param string $email
   *
   * @return array
   */
  public function getUserByEmail(string $email): array|bool {
    $query = "SELECT * FROM users WHERE email='{$email}'";
    $stmt = $this->query($query);

    // Fetch the result as an associative array.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
  }

  /**
   * Create an user.
   * 
   * @param array $data
   *
   * @return mixed
   */
  public function create(array $data): mixed {
    $password = password_hash($data['password'], PASSWORD_DEFAULT);;
    $query = "INSERT INTO users (name, email, password) VALUES ('{$data['name']}', '{$data['email']}', '{$password}')";
    $stmt = $this->query($query);

    return $stmt;
  }
}
