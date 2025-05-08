<?php
class UserService {
    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
    }

    // Register a new user
    public function registerUser($data) {
        // Validate email and password before inserting
        if (empty($data['email']) || empty($data['password'])) {
            throw new Exception("Email and password are required.");
        }

        // Check if user already exists
        $existingUser = $this->userDao->getByEmail($data['email']);
        if ($existingUser) {
            throw new Exception("User with this email already exists.");
        }

        // Create new user
        return $this->userDao->create($data);
    }

    // Get user by ID
    public function getUserById($id) {
        return $this->userDao->getById($id);
    }

    // Update user details
    public function updateUser($id, $data) {
        return $this->userDao->update($id, $data);
    }

    // Delete user
    public function deleteUser($id) {
        return $this->userDao->delete($id);
    }
}
?>
