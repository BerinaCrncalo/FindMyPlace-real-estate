<?php
require_once 'BaseDao.php';

class ContactMessageDao extends BaseDao {
    public function __construct() {
        parent::__construct("contact_messages");
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM contact_messages WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        $stmt = $this->connection->query("SELECT * FROM contact_messages");
        return $stmt->fetchAll();
    }

    public function create($data) {
        if (!$this->isValidContactMessage($data)) {
            throw new InvalidArgumentException("Invalid contact message data.");
        }

        $sentAt = date('Y-m-d H:i:s');

        $stmt = $this->connection->prepare(
            "INSERT INTO contact_messages (name, email, message, sent_at, contact_messages_user_FK) 
             VALUES (:name, :email, :message, :sent_at, :user_id)"
        );

        $stmt->bindValue(':name', htmlspecialchars($data['name']), PDO::PARAM_STR);
        $stmt->bindValue(':email', htmlspecialchars($data['email']), PDO::PARAM_STR);
        $stmt->bindValue(':message', htmlspecialchars($data['message']), PDO::PARAM_STR);
        $stmt->bindValue(':sent_at', $sentAt, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        return $this->connection->lastInsertId(); 
    }

    public function update($id, $data) {
        if (!$this->isValidContactMessage($data, false)) {
            throw new InvalidArgumentException("Invalid update data.");
        }

        $stmt = $this->connection->prepare(
            "UPDATE contact_messages 
             SET name = :name, email = :email, message = :message 
             WHERE id = :id"
        );

        $stmt->bindValue(':name', htmlspecialchars($data['name']), PDO::PARAM_STR);
        $stmt->bindValue(':email', htmlspecialchars($data['email']), PDO::PARAM_STR);
        $stmt->bindValue(':message', htmlspecialchars($data['message']), PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM contact_messages WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    private function isValidContactMessage($data, $requireUserId = true) {
        return isset($data['name'], $data['email'], $data['message']) &&
               is_string($data['name']) &&
               is_string($data['email']) &&
               is_string($data['message']) &&
               (!$requireUserId || isset($data['user_id']) && filter_var($data['user_id'], FILTER_VALIDATE_INT));
    }
}
?>
