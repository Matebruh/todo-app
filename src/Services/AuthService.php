<?php

class AuthService
{
    private User $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    public function register(string $name, string $email, string $password): bool {
        return $this->userModel->create($name, $email, $password);
    }

    public function login(string $email, string $password): bool {

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];

        return true;
    }

    public function logout(): void {
        session_destroy();
    }

    public function isLoggedIn(): bool {
        return isset($_SESSION['user_id']);
    }
}