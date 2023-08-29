<?php
// app/Models/UserModel.php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'userid';
    protected $allowedFields = ['email', 'password_hash', 'username']; // Add more fields as needed

    public function getUserByEmail($email) {
        return $this->select($this->allowedFields)->where('email', $email)->first();
    }

    public function authenticateUser($email, $password) {
        $user = $this->getUserByEmail($email);

        if (!$user) {
            return false; // User not found
        }

        return password_verify($password, $user['password_hash']);
    }

    public function createUser($data) {
        return $this->insert($data);
    }
}
