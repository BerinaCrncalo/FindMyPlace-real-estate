<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("user");
    }

    public function getById($id) {
        // Match BaseDao signature, no type hint
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        return parent::getAll();
    }

    public function getByEmail($email) {
        // Override BaseDao to query 'user' table explicitly with validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format.");
        }

        $stmt = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        if (!$this->isValidUserData($data, true)) {
            throw new InvalidArgumentException("Invalid user data.");
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $this->connection->prepare(
            "INSERT INTO user (email, password, role, phone_number, full_name, created_at) 
             VALUES (:email, :password, :role, :phone_number, :full_name, NOW())"
        );

        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
        $stmt->bindValue(':role', $data['role'], PDO::PARAM_STR);
        $stmt->bindValue(':phone_number', $data['phone_number'], PDO::PARAM_STR);
        $stmt->bindValue(':full_name', $data['full_name'], PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new RuntimeException("Failed to create user.");
        }

        return $this->connection->lastInsertId();
    }

    public function update($id, $data) {
        if (!$this->isValidUserData($data, false)) {
            throw new InvalidArgumentException("Invalid user data.");
        }

        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // Get existing password if no new password provided
            $existingUser = $this->getById($id);
            if (!$existingUser) {
                throw new RuntimeException("User not found.");
            }
            $data['password'] = $existingUser['password'];
        }

        // Build SET clause dynamically
        $setClause = "";
        $params = [];
        foreach (['email', 'password', 'role', 'phone_number', 'full_name'] as $field) {
            if (isset($data[$field])) {
                $setClause .= "$field = :$field, ";
                $params[$field] = $data[$field];
            }
        }
        $setClause = rtrim($setClause, ", ");

        if (empty($setClause)) {
            throw new InvalidArgumentException("No fields to update.");
        }

        $params['id'] = $id;

        $stmt = $this->connection->prepare("UPDATE user SET $setClause WHERE id = :id");

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
        }

        if (!$stmt->execute()) {
            throw new RuntimeException("Failed to update user.");
        }

        return $stmt->rowCount();
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new RuntimeException("Failed to delete user.");
        }
        return $stmt->rowCount();
    }

    private function isValidUserData(array $data, bool $isCreate = true): bool {
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (empty($data['role']) || !is_string($data['role'])) {
            return false;
        }
        if (empty($data['phone_number']) || !preg_match('/^\+?[0-9\s\-]{7,15}$/', $data['phone_number'])) {
            return false;
        }
        if (empty($data['full_name']) || !is_string($data['full_name'])) {
            return false;
        }
        if ($isCreate) {
            if (empty($data['password']) || !is_string($data['password']) || strlen($data['password']) < 8) {
                return false;
            }
        } else {
            if (isset($data['password']) && (!is_string($data['password']) || strlen($data['password']) < 8)) {
                return false;
            }
        }
        return true;
    }
}
?>
