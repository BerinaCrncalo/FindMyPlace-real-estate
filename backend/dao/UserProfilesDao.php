<?php
require_once 'BaseDao.php';

class UserProfilesDao extends BaseDao {
    public function __construct() {
        parent::__construct("user_profiles");
    }

    public function getByUserId($user_id) {
        if (!is_int($user_id) && !ctype_digit($user_id)) {
            throw new InvalidArgumentException("Invalid user ID.");
        }

        $stmt = $this->connection->prepare("SELECT * FROM user_profiles WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        if (!$this->isValidProfileData($data, true)) {
            throw new InvalidArgumentException("Invalid profile data.");
        }

        $stmt = $this->connection->prepare(
            "INSERT INTO user_profiles (user_id, bio, profile_picture_url, location) 
             VALUES (:user_id, :bio, :profile_picture_url, :location)"
        );

        $stmt->bindValue(':user_id', (int)$data['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':bio', $data['bio'], PDO::PARAM_STR);
        $stmt->bindValue(':profile_picture_url', $data['profile_picture_url'], PDO::PARAM_STR);
        $stmt->bindValue(':location', $data['location'], PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new RuntimeException("Failed to create user profile.");
        }

        return $this->connection->lastInsertId();
    }

    public function update($id, $data) {
        if (!is_int($id) && !ctype_digit($id)) {
            throw new InvalidArgumentException("Invalid profile ID.");
        }

        if (!$this->isValidProfileData($data, false)) {
            throw new InvalidArgumentException("Invalid profile data.");
        }

        $data['id'] = (int)$id;

        $stmt = $this->connection->prepare(
            "UPDATE user_profiles 
             SET bio = :bio, profile_picture_url = :profile_picture_url, location = :location 
             WHERE id = :id"
        );

        $stmt->bindValue(':bio', $data['bio'], PDO::PARAM_STR);
        $stmt->bindValue(':profile_picture_url', $data['profile_picture_url'], PDO::PARAM_STR);
        $stmt->bindValue(':location', $data['location'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new RuntimeException("Failed to update user profile.");
        }

        return $stmt->rowCount();
    }

    public function delete($id) {
        if (!is_int($id) && !ctype_digit($id)) {
            throw new InvalidArgumentException("Invalid profile ID.");
        }

        $stmt = $this->connection->prepare("DELETE FROM user_profiles WHERE id = :id");
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new RuntimeException("Failed to delete user profile.");
        }

        return $stmt->rowCount();
    }

    private function isValidProfileData(array $data, bool $isCreate = true): bool {
        // user_id is required on create
        if ($isCreate) {
            if (empty($data['user_id']) || !is_numeric($data['user_id'])) {
                return false;
            }
        }

        // bio can be empty but must be a string
        if (isset($data['bio']) && !is_string($data['bio'])) {
            return false;
        }

        // profile_picture_url must be a valid URL or empty string
        if (isset($data['profile_picture_url']) && !empty($data['profile_picture_url'])) {
            if (!filter_var($data['profile_picture_url'], FILTER_VALIDATE_URL)) {
                return false;
            }
        }

        // location must be string or empty
        if (isset($data['location']) && !is_string($data['location'])) {
            return false;
        }

        return true;
    }
}
?>
