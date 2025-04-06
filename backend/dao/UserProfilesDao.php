<?php
require_once 'BaseDao.php';

class UserProfilesDao extends BaseDao {
    public function __construct() {
        parent::__construct("user_profiles");
    }

    public function getByUserId($user_id) {
        // Fetch the profile of a user by their user ID
        $stmt = $this->connection->prepare("SELECT * FROM user_profiles WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        // Insert a new user profile with user_id, bio, profile picture URL, and location
        $stmt = $this->connection->prepare(
            "INSERT INTO user_profiles (user_id, bio, profile_picture_url, location) 
             VALUES (:user_id, :bio, :profile_picture_url, :location)"
        );

        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':bio', $data['bio']);
        $stmt->bindParam(':profile_picture_url', $data['profile_picture_url']);
        $stmt->bindParam(':location', $data['location']);

        $stmt->execute();
        return $this->connection->lastInsertId();  
    }

    public function update($id, $data) {
        // Update the user profile with the new bio, profile picture URL, and location
        $data['id'] = $id;  // Include the ID for the WHERE clause
        $stmt = $this->connection->prepare(
            "UPDATE user_profiles 
             SET bio = :bio, profile_picture_url = :profile_picture_url, location = :location 
             WHERE id = :id"
        );

        // Execute the update query
        $stmt->execute($data);
    }

    public function delete($id) {
        // Delete a user profile by its ID
        $stmt = $this->connection->prepare("DELETE FROM user_profiles WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
