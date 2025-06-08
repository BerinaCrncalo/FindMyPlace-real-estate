<?php
class ContactMessageService {
    private $contactMessageDao;

    public function __construct() {
        $this->contactMessageDao = new ContactMessageDao();
    }

    public function createContactMessage($data) {
        $name = htmlspecialchars(trim($data['name'] ?? ''));
        $email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $message = htmlspecialchars(trim($data['message'] ?? ''));
        $user_id = intval($data['user_id'] ?? 0); // Adjust based on session/auth if needed

        if (!$name) throw new Exception("Name is required.");
        if (!$email) throw new Exception("Valid email is required.");
        if (!$message) throw new Exception("Message is required.");
        if (!$user_id) throw new Exception("User ID is required.");

        return $this->contactMessageDao->create([
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'user_id' => $user_id
        ]);
    }

    public function getAllContactMessages() {
        return $this->contactMessageDao->getAll();
    }

    public function getContactMessageById($id) {
        if (empty($id)) throw new Exception("Contact message ID is required.");
        return $this->contactMessageDao->getById($id);
    }

    public function updateContactMessage($id, $data) {
        $name = htmlspecialchars(trim($data['name'] ?? ''));
        $email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $message = htmlspecialchars(trim($data['message'] ?? ''));

        if (!$name || !$email || !$message) {
            throw new Exception("All fields are required.");
        }

        $this->contactMessageDao->update($id, [
            'name' => $name,
            'email' => $email,
            'message' => $message
        ]);
    }

    public function deleteContactMessage($id) {
        if (empty($id)) throw new Exception("Contact message ID is required.");
        $this->contactMessageDao->delete($id);
    }
}
?>