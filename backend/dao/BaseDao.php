<?php

class BaseDao {
    protected $connection;
    private $table;

    // Initializes connection and table name
    public function __construct($table) {
        $this->table = $table;

        // Connection parameters
        $host = "localhost";
        $dbname = "FindMyPlace";
        $username = "root";
        $password = "database1";

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("DB connection failed: " . $e->getMessage());
        }
    }

    // Fetch records
    public function getAll() {
        $stmt = $this->connection->query("SELECT * FROM $this->table");
        return $stmt->fetchAll();
    }

    // Fetch record by ID
    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    // Get a user by email
    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM $this->table WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function create($data) {
        // Build the query dynamically from the $data
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $stmt = $this->connection->prepare("INSERT INTO $this->table ($columns) VALUES ($placeholders)");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    public function update($id, $data) {
        // Builds SET part of the query dynamically
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ", ");

        // Prepares SQL statement
        $stmt = $this->connection->prepare("UPDATE $this->table SET $setClause WHERE id = :id");
        $data['id'] = $id;

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // Executes and return the number of affected rows
        $stmt->execute();
        return $stmt->rowCount();
    }
}

?>
