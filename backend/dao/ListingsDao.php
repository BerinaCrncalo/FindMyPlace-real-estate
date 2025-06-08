<?php
require_once 'BaseDao.php';

class ListingsDao extends BaseDao {
    public function __construct() {
        parent::__construct("listings");
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM listings WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        $stmt = $this->connection->query("SELECT * FROM listings");
        return $stmt->fetchAll();
    }

    public function create($data) {
        if (!$this->isValidListingData($data)) {
            throw new InvalidArgumentException("Invalid listing data.");
        }

        $created = date('Y-m-d H:i:s');
        $photoPath = $data['photo_path'] ?? null;

        $stmt = $this->connection->prepare(
            "INSERT INTO listings (title, description, price, location, category_id, user_id, created, photo_path) 
             VALUES (:title, :description, :price, :location, :category_id, :user_id, :created, :photo_path)"
        );

        $stmt->bindValue(':title', htmlspecialchars($data['title']), PDO::PARAM_STR);
        $stmt->bindValue(':description', htmlspecialchars($data['description']), PDO::PARAM_STR);
        $stmt->bindValue(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindValue(':location', htmlspecialchars($data['location']), PDO::PARAM_STR);
        $stmt->bindValue(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':created', $created, PDO::PARAM_STR);
        $stmt->bindValue(':photo_path', $photoPath, PDO::PARAM_STR);

        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    public function update($id, $data) {
        if (!$this->isValidListingData($data, false)) {
            throw new InvalidArgumentException("Invalid listing update data.");
        }

        $sql = "UPDATE listings SET title = :title, description = :description, price = :price, 
                location = :location, category_id = :category_id, user_id = :user_id";

        if (isset($data['photo_path'])) {
            $sql .= ", photo_path = :photo_path";
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue(':title', htmlspecialchars($data['title']), PDO::PARAM_STR);
        $stmt->bindValue(':description', htmlspecialchars($data['description']), PDO::PARAM_STR);
        $stmt->bindValue(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindValue(':location', htmlspecialchars($data['location']), PDO::PARAM_STR);
        $stmt->bindValue(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);

        if (isset($data['photo_path'])) {
            $stmt->bindValue(':photo_path', $data['photo_path'], PDO::PARAM_STR);
        }

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM listings WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    private function isValidListingData($data, $checkPhoto = true) {
        return isset($data['title'], $data['description'], $data['price'], $data['location'],
                      $data['category_id'], $data['user_id']) &&
               is_string($data['title']) &&
               is_string($data['description']) &&
               is_numeric($data['price']) &&
               is_string($data['location']) &&
               filter_var($data['category_id'], FILTER_VALIDATE_INT) !== false &&
               filter_var($data['user_id'], FILTER_VALIDATE_INT) !== false &&
               (!$checkPhoto || !isset($data['photo_path']) || is_string($data['photo_path']));
    }
}
?>
