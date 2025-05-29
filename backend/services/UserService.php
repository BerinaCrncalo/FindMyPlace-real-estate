<?php
class UserService {
    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
    }

    // Register a new user
    public function registerUser($data) {
        if (empty($data['email']) || empty($data['password'])) {
            throw new Exception("Email and password are required.");
        }

        // Check if user already exists
        $existingUser = $this->userDao->getByEmail($data['email']);
        if ($existingUser) {
            throw new Exception("User with this email already exists.");
        }

        // Hash the password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        // Assign default role if not set
        $role = isset($data['role']) ? $data['role'] : 'user';

        // Create user
        $newUser = [
            'email' => $data['email'],
            'password' => $hashedPassword,
            'role' => $role
        ];

        return $this->userDao->create($newUser);
    }

    // Authenticate user (login)
    public function authenticateUser($email, $password) {
        $user = $this->userDao->getByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            throw new Exception("Invalid email or password.");
        }

        // Don't expose password in response
        unset($user['password']);
        return $user;
    }

    // Get user by ID
    public function getUserById($id) {
        $user = $this->userDao->getById($id);
        if ($user) unset($user['password']);
        return $user;
    }

    // Update user details
    public function updateUser($id, $data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return $this->userDao->update($id, $data);
    }

    // Delete user
    public function deleteUser($id) {
        return $this->userDao->delete($id);
    }
}
?>
