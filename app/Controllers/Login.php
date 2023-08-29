<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController {
    public function index(): string {
        return view('login');
    }

    public function processLogin() {
        helper('form');
        $validation = \Config\Services::validation();

        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('login', ['validation' => $validation]);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        if ($userModel->authenticateUser($email, $password)) {
            // Successful authentication
            $userData = $userModel->getUserByEmail($email);
            $session = session();
            $session->set('user', $userData); // Store user data in session

            return redirect()->to(base_url('dashboard'));
        } else {
            // Unsuccessful authentication
            return redirect()->to(base_url('login'))->with('error', 'Authentication failed');
        }
    }

    public function processRegistration() {
        helper('form');
        $validation = \Config\Services::validation();

        $validation->setRules([
            'name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('login', ['validation' => $validation]);
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $name,
            'email' => $email,
            'password_hash' => $hashedPassword
        ];

        $userModel->createUser($data);
        // Successful authentication
        $userData = $userModel->getUserByEmail($email);
        $session = session();
        $session->set('user', $userData); // Store user data in session

        return redirect()->to(base_url('dashboard'))->with('success', 'Registration successful! Please log in.');
    }

    public function logout() {
        // Get and destroy the session
        $session = session();
        $session->destroy();

        return redirect()->to(base_url()); // Redirect to the base URL
    }

}
