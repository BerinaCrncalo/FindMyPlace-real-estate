<?php
require_once 'BaseDao.php';

class SavedSearchesDao extends BaseDao {
    public function __construct() {
        parent::__construct("saved_searches");
    }

    public function getByUserId($user_id) {
        $stmt = $this->connection->prepare("SELECT * FROM saved_searches WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data) {
        if (!$this->isValidSavedSearch($data)) {
            throw new InvalidArgumentException("Invalid saved search data.");
        }

        $createdAt = date('Y-m-d H:i:s');

        $stmt = $this->connection->prepare(
            "INSERT INTO saved_searches (user_id, search_query, created_at) 
             VALUES (:user_id, :search_query, :created_at)"
        );

        $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':search_query', htmlspecialchars($data['search_query']), PDO::PARAM_STR);
        $stmt->bindValue(':created_at', $createdAt, PDO::PARAM_STR);

        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    public function update($id, $data) {
        if (!isset($data['search_query']) || !is_string($data['search_query'])) {
            throw new InvalidArgumentException("Invalid search query.");
        }

        $stmt = $this->connection->prepare(
            "UPDATE saved_searches 
             SET search_query = :search_query 
             WHERE id = :id"
        );

        $stmt->bindValue(':search_query', htmlspecialchars($data['search_query']), PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM saved_searches WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    private function isValidSavedSearch($data) {
        return isset($data['user_id'], $data['search_query']) &&
               filter_var($data['user_id'], FILTER_VALIDATE_INT) !== false &&
               is_string($data['search_query']);
    }
}
?>
