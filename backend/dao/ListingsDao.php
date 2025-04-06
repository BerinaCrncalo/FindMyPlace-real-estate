<?php
require_once 'BaseDao.php';

class ListingsDao extends BaseDao {
    public function __construct() {
        parent::__construct("listings");
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM listings WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        $stmt = $this->connection->query("SELECT * FROM listings");
        return $stmt->fetchAll();
    }

    public function create($data) {
        // Add the current timestamp for the 'created' field
        $data['created'] = date('Y-m-d H:i:s');  // Format for DATETIME

        $stmt = $this->connection->prepare(
            "INSERT INTO listings (title, description, price, location, category_id, user_id, created) 
             VALUES (:title, :description, :price, :location, :category_id, :user_id, :created)"
        );

        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':location', $data['location']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':created', $data['created']);

        $stmt->execute();
        return $this->connection->lastInsertId(); 
    }

    public function update($id, $data) {
        // Add the ID to the data for binding
        $data['id'] = $id;

        $stmt = $this->connection->prepare(
            "UPDATE listings SET title = :title, description = :description, price = :price, 
             location = :location, category_id = :category_id, user_id = :user_id WHERE id = :id"
        );

        $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM listings WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
