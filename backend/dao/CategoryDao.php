<?php
require_once 'BaseDao.php';

class CategoryDao extends BaseDao {
    public function __construct() {
        parent::__construct("category");
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        $stmt = $this->connection->query("SELECT * FROM category");
        return $stmt->fetchAll();
    }

    public function create($data) {
        if (!$this->isValidCategoryData($data)) {
            throw new InvalidArgumentException("Invalid category data.");
        }

        $stmt = $this->connection->prepare("INSERT INTO category (name) VALUES (:name)");
        $stmt->bindValue(':name', htmlspecialchars($data['name']), PDO::PARAM_STR);
        $stmt->execute();
        return $this->connection->lastInsertId(); 
    }

    public function update($id, $data) {
        if (!$this->isValidCategoryData($data)) {
            throw new InvalidArgumentException("Invalid category data.");
        }

        $stmt = $this->connection->prepare("UPDATE category SET name = :name WHERE id = :id");
        $stmt->bindValue(':name', htmlspecialchars($data['name']), PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM category WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    private function isValidCategoryData($data) {
        return isset($data['name']) && is_string($data['name']) && strlen(trim($data['name'])) > 0 && strlen($data['name']) <= 255;
    }
}
?>
