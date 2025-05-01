<?php
class ContactMessageService {
    private $contactMessageDao;

    public function __construct() {
        $this->contactMessageDao = new ContactMessageDao();
    }

    // Create a new contact message
    public function createContactMessage($data) {
        // Validation logic
        if (empty($data['name'])) {
            throw new Exception("Name is required.");
        }
        if (empty($data['email'])) {
            throw new Exception("Email is required.");
        }
        if (empty($data['message'])) {
            throw new Exception("Message is required.");
        }

        // Call DAO to insert the contact message
        $contactMessageId = $this->contactMessageDao->create($data);
        return $contactMessageId;
    }

    // Get all contact messages
    public function getAllContactMessages() {
        return $this->contactMessageDao->getAll();
    }

    // Get a contact message by ID
    public function getContactMessageById($id) {
        if (empty($id)) {
            throw new Exception("Contact message ID is required.");
        }
        return $this->contactMessageDao->getById($id);
    }

    // Update a contact message
    public function updateContactMessage($id, $data) {
        // Validation logic
        if (empty($data['name'])) {
            throw new Exception("Name is required.");
        }
        if (empty($data['email'])) {
            throw new Exception("Email is required.");
        }
        if (empty($data['message'])) {
            throw new Exception("Message is required.");
        }

        $this->contactMessageDao->update($id, $data);
    }

    // Delete a contact message
    public function deleteContactMessage($id) {
        if (empty($id)) {
            throw new Exception("Contact message ID is required.");
        }

        $this->contactMessageDao->delete($id);
    }
}
?>