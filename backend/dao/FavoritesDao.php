<?php
require_once 'BaseDao.php';

class FavoritesDao extends BaseDao {
    public function __construct() {
        parent::__construct("favorites");
    }

    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM favorites WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->connection->prepare(
            "INSERT INTO favorites (user_id, listings_id) VALUES (:user_id, :listings_id)"
        );
        $stmt->execute($data);
        return $this->connection->lastInsertId();
    }

    public function delete($id) {
        list($user_id, $listings_id) = explode('|', $id);

        $stmt = $this->connection->prepare("DELETE FROM favorites WHERE user_id = :user_id AND listings_id = :listings_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':listings_id', $listings_id);
        $stmt->execute();
    }
}
?>
