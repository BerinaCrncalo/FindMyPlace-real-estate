<?php

class BaseDao {
    protected $connection;
    protected $table;

    // Accept only whitelisted table names
    private static $allowedTables = ['user', 'user_profiles'];

    public function __construct($table) {
        if (!in_array($table, self::$allowedTables)) {
            throw new InvalidArgumentException("Invalid table name.");
        }

        $this->table = $table;

        $host = "localhost";
        $dbname = "FindMyPlace";
        $username = "root";
        $password = "database1";

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("DB connection failed: " . $e->getMessage());
        }
    }

    public function getAll() {
        $query = "SELECT * FROM `{$this->table}`";
        $stmt = $this->connection->query($query);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM `{$this->table}` WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM `{$this->table}` WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function create($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $stmt = $this->connection->prepare("INSERT INTO `{$this->table}` ($columns) VALUES ($placeholders)");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    public function update($id, $data) {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "`$key` = :$key, ";
        }
        $setClause = rtrim($setClause, ", ");

        $data['id'] = $id;
        $stmt = $this->connection->prepare("UPDATE `{$this->table}` SET $setClause WHERE id = :id");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->rowCount();
    }
}

?>
