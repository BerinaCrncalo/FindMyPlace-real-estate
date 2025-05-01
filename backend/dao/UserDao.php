<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct("user");
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        $stmt = $this->connection->query("SELECT * FROM user");
        return $stmt->fetchAll();
    }
    // Fetch a user by email
    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        // Hash the password before inserting
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Prepare statement
        $stmt = $this->connection->prepare(
            "INSERT INTO user (email, password, role, phone_number, full_name, created_at) 
            VALUES (:email, :password, :role, :phone_number, :full_name, NOW())"
        );

        // Bind
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $stmt->bindParam(':full_name', $data['full_name']);

        $stmt->execute();
        return $this->connection->lastInsertId(); 
    }

    public function update($id, $data) {
        // Add the 'id' to the data array to ensure it's passed correctly
        $data['id'] = $id;
        // Update query with placeholders
        $stmt = $this->connection->prepare(
            "UPDATE users SET email = :email, password = :password, phone_number= :phone_number, role = :role, full_name = :full_name WHERE id = :id"
        );
        $stmt->execute($data);
    }
    

    public function delete($id) {
        // Prepare delete statement
        $stmt = $this->connection->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
