<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class ContactMessageController {

    /**
     * @OA\Post(
     *     path="/contact_messages",
     *     summary="Create a contact message",
     *     description="Creates a contact message with the provided data.",
     *     operationId="createContactMessage",
     *     tags={"ContactMessages"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"user_id", "message"},
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="message", type="string", example="Hello, I am interested in the property.")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=201,
     *         description="Contact message created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contact message created successfully"),
     *             @OA\Property(property="contact_message_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function createContactMessage() {
        $data = Flight::request()->data->getData();

        // Basic validation
        if (
            !isset($data['user_id']) || !is_int($data['user_id']) ||
            !isset($data['message']) || !is_string($data['message']) || trim($data['message']) === ''
        ) {
            Flight::json(['message' => 'Invalid input: user_id and message are required, message must be a non-empty string'], 400);
            return;
        }

        // Sanitize message to prevent XSS
        $message = htmlspecialchars(trim($data['message']), ENT_QUOTES, 'UTF-8');
        $userId = $data['user_id'];

        try {
            $contactMessageService = new ContactMessageService();
            $contactMessageId = $contactMessageService->createContactMessage([
                'user_id' => $userId,
                'message' => $message
            ]);
            Flight::json(['message' => 'Contact message created successfully', 'contact_message_id' => $contactMessageId], 201);
        } catch (Exception $e) {
            Flight::json(['message' => 'Error creating contact message: ' . $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/contact_messages",
     *     summary="Get all contact messages",
     *     description="Returns a list of all contact messages.",
     *     operationId="getAllContactMessages",
     *     tags={"ContactMessages"},
     *     @OA\Response(
     *         response=200,
     *         description="List of contact messages",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ContactMessage"))
     *     )
     * )
     */
    public static function getAllContactMessages() {
        try {
            $contactMessageService = new ContactMessageService();
            $contactMessages = $contactMessageService->getAllContactMessages();
            Flight::json($contactMessages, 200);
        } catch (Exception $e) {
            Flight::json(['message' => 'Error fetching contact messages: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/contact_messages/{id}",
     *     summary="Get contact message by ID",
     *     description="Returns a single contact message by its ID.",
     *     operationId="getContactMessageById",
     *     tags={"ContactMessages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact message details",
     *         @OA\JsonContent(ref="#/components/schemas/ContactMessage")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Message not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contact message not found")
     *         )
     *     )
     * )
     */
    public static function getContactMessageById($id) {
        if (!is_numeric($id) || intval($id) <= 0) {
            Flight::json(['message' => 'Invalid contact message ID'], 400);
            return;
        }
        $id = intval($id);

        try {
            $contactMessageService = new ContactMessageService();
            $contactMessage = $contactMessageService->getContactMessageById($id);
            if (!$contactMessage) {
                Flight::json(['message' => 'Contact message not found'], 404);
                return;
            }
            Flight::json($contactMessage, 200);
        } catch (Exception $e) {
            Flight::json(['message' => 'Error fetching contact message: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/contact_messages/{id}",
     *     summary="Update contact message",
     *     description="Updates an existing contact message by its ID.",
     *     operationId="updateContactMessage",
     *     tags={"ContactMessages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"message"},
     *                 @OA\Property(property="message", type="string", example="Updated message")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Contact message updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contact message updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Message not found or invalid data",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function updateContactMessage($id) {
        if (!is_numeric($id) || intval($id) <= 0) {
            Flight::json(['message' => 'Invalid contact message ID'], 400);
            return;
        }
        $id = intval($id);

        $data = Flight::request()->data->getData();

        if (!isset($data['message']) || !is_string($data['message']) || trim($data['message']) === '') {
            Flight::json(['message' => 'Invalid input: message is required and must be a non-empty string'], 400);
            return;
        }

        // Sanitize message
        $message = htmlspecialchars(trim($data['message']), ENT_QUOTES, 'UTF-8');

        try {
            $contactMessageService = new ContactMessageService();
            $updated = $contactMessageService->updateContactMessage($id, ['message' => $message]);

            if (!$updated) {
                Flight::json(['message' => 'Contact message not found or could not be updated'], 400);
                return;
            }

            Flight::json(['message' => 'Contact message updated successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => 'Error updating contact message: ' . $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/contact_messages/{id}",
     *     summary="Delete contact message",
     *     description="Deletes a contact message by its ID.",
     *     operationId="deleteContactMessage",
     *     tags={"ContactMessages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact message deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contact message deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Message not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function deleteContactMessage($id) {
        if (!is_numeric($id) || intval($id) <= 0) {
            Flight::json(['message' => 'Invalid contact message ID'], 400);
            return;
        }
        $id = intval($id);

        try {
            $contactMessageService = new ContactMessageService();
            $deleted = $contactMessageService->deleteContactMessage($id);

            if (!$deleted) {
                Flight::json(['message' => 'Contact message not found or could not be deleted'], 400);
                return;
            }

            Flight::json(['message' => 'Contact message deleted successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => 'Error deleting contact message: ' . $e->getMessage()], 400);
        }
    }
}
