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
    $query = "SELECT id, name, email FROM users";
    $stmt = $this->query($query);

    // Fetch all results as an associative array.
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Get an user by ID.
   * 
   * @param int $id
   *
   * @return array
   */
  public function getUserById(int $id): array|bool {
    return $this->fetch('users', 'id', $id);
  }

  /**
   * Get an user by email.
   * 
   * @param string $email
   *
   * @return array
   */
  public function getUserByEmail(string $email): array|bool {
    return $this->fetch('users', 'email', $email);
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

    return $this->query($query);
  }

  /**
   * Update an user.
   * 
   * @param array $data
   *
   * @return mixed
   */
  public function update(array $data): mixed {
    $query = "UPDATE users SET name='{$data['name']}', email='{$data['email']}' WHERE id={$data['id']}";

    return $this->query($query);
  }

  /**
   * Delete an user.
   * 
   * @param int $id
   *
   * @return mixed
   */
  public function delete(int $id): mixed {
    $query = "DELETE FROM users WHERE id={$id}";

    return $this->query($query);
  }
}
