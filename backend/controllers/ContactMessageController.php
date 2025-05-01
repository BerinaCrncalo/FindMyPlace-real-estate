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
        $contactMessageService = new ContactMessageService();

        try {
            // Call service to create the contact message
            $contactMessageId = $contactMessageService->createContactMessage($data);
            Flight::json(['message' => 'Contact message created successfully', 'contact_message_id' => $contactMessageId], 201);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
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
        $contactMessageService = new ContactMessageService();
        $contactMessages = $contactMessageService->getAllContactMessages();
        Flight::json($contactMessages);
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
     *         response=400,
     *         description="Message not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function getContactMessageById($id) {
        $contactMessageService = new ContactMessageService();

        try {
            $contactMessage = $contactMessageService->getContactMessageById($id);
            Flight::json($contactMessage);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
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
        $data = Flight::request()->data->getData();
        $contactMessageService = new ContactMessageService();

        try {
            $contactMessageService->updateContactMessage($id, $data);
            Flight::json(['message' => 'Contact message updated successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
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
        $contactMessageService = new ContactMessageService();

        try {
            $contactMessageService->deleteContactMessage($id);
            Flight::json(['message' => 'Contact message deleted successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }
}
?>
