<?php
require_once 'BaseDao.php';

class SavedSearchesDao extends BaseDao {
    public function __construct() {
        parent::__construct("saved_searches");
    }

    public function getByUserId($user_id) {
        // Fetches all saved searches for a specific user
        $stmt = $this->connection->prepare("SELECT * FROM saved_searches WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data) {
        // Adds the current timestamp for the 'created_at' field
        $data['created_at'] = date('Y-m-d H:i:s');  // This is the format for MySQL DATETIME

        // Insers a new saved search
        $stmt = $this->connection->prepare(
            "INSERT INTO saved_searches (user_id, search_query, created_at) 
             VALUES (:user_id, :search_query, :created_at)"
        );

        // Binds parameters for user ID, search query, and created_at timestamp
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':search_query', $data['search_query']);
        $stmt->bindParam(':created_at', $data['created_at']);
        

        $stmt->execute();
        return $this->connection->lastInsertId(); 
    }

    public function update($id, $data) {
        // Updates the search query for a specific saved search
        $data['id'] = $id;  // Includes the ID for the WHERE clause
        $stmt = $this->connection->prepare(
            "UPDATE saved_searches 
             SET search_query = :search_query 
             WHERE id = :id"
        );

        $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM saved_searches WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
