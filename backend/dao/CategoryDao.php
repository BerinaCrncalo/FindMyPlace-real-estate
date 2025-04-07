<?php
require_once 'BaseDao.php';

class CategoryDao extends BaseDao {
    public function __construct() {
        parent::__construct("category");
    }

    public function getById($id) {
        // Fetch a single category by its ID
        $stmt = $this->connection->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        // Fetch all categories
        $stmt = $this->connection->query("SELECT * FROM category");
        return $stmt->fetchAll();
    }

    public function create($data) {
        // Insert a new category
        $stmt = $this->connection->prepare("INSERT INTO category (name) VALUES (:name)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->execute();
        return $this->connection->lastInsertId(); 
    }

    public function update($id, $data) {
        // Update category information based on ID
        $data['id'] = $id;
        $stmt = $this->connection->prepare("UPDATE category SET name = :name WHERE id = :id");
        $stmt->execute($data);
    }

    public function delete($id) {
        // Delete category by ID
        $stmt = $this->connection->prepare("DELETE FROM category WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
