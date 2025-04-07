<?php
require_once 'BaseDao.php';

class ContactMessageDao extends BaseDao {
    public function __construct() {
        parent::__construct("contact_messages");
    }

    public function getById($id) {
        // Fetch a single contact message by its ID
        $stmt = $this->connection->prepare("SELECT * FROM contact_messages WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAll() {
        // Fetch all contact messages
        $stmt = $this->connection->query("SELECT * FROM contact_messages");
        return $stmt->fetchAll();
    }

    public function create($data) {
        // Add the current timestamp for the 'sent_at' field
        $data['sent_at'] = date('Y-m-d H:i:s');  // Format for DATETIME

        // Insert the new contact message
        $stmt = $this->connection->prepare(
            "INSERT INTO contact_messages (name, email, message, sent_at, contact_messages_user_FK) 
             VALUES (:name, :email, :message, :sent_at, :user_id)"
        );

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':message', $data['message']);
        $stmt->bindParam(':sent_at', $data['sent_at']);
        $stmt->bindParam(':user_id', $data['user_id']); 

        $stmt->execute();
        return $this->connection->lastInsertId(); 
    }

    public function update($id, $data) {
        // The sent_at field should not be updated
        unset($data['sent_at']);
        $data['id'] = $id;

        // Update the contact message by ID
        $stmt = $this->connection->prepare(
            "UPDATE contact_messages 
             SET name = :name, email = :email, message = :message 
             WHERE id = :id"
        );

        $stmt->execute($data);
    }

    public function delete($id) {
        // Delete a contact message by its ID
        $stmt = $this->connection->prepare("DELETE FROM contact_messages WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
