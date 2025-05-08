<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class UserController {

    /**
     * @OA\Post(
     *     path="/users/register",
     *     summary="Register a new user",
     *     description="Registers a new user to the platform.",
     *     operationId="registerUser",
     *     tags={"Users"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"username", "email", "password"},
     *                 @OA\Property(property="username", type="string", example="john_doe"),
     *                 @OA\Property(property="email", type="string", example="john_doe@example.com"),
     *                 @OA\Property(property="password", type="string", example="password123")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully")
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
    public static function registerUser() {
        $data = Flight::request()->data->getData();
        $userService = new UserService();

        try {
            $userService->registerUser($data);
            Flight::json(['message' => 'User registered successfully'], 201);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Get user by ID",
     *     description="Retrieves a specific user by their ID.",
     *     operationId="getUserById",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function getUserById($id) {
        $userService = new UserService();

        try {
            $user = $userService->getUserById($id);
            Flight::json($user);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     summary="Update user details",
     *     description="Updates the details of a user by their ID.",
     *     operationId="updateUser",
     *     tags={"Users"},
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
     *                 required={"username", "email", "password"},
     *                 @OA\Property(property="username", type="string", example="john_doe_updated"),
     *                 @OA\Property(property="email", type="string", example="john_doe_updated@example.com"),
     *                 @OA\Property(property="password", type="string", example="newpassword123")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User updated successfully")
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
    public static function updateUser($id) {
        $data = Flight::request()->data->getData();
        $userService = new UserService();

        try {
            $userService->updateUser($id, $data);
            Flight::json(['message' => 'User updated successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Delete a user",
     *     description="Deletes a user by their ID.",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function deleteUser($id) {
        $userService = new UserService();

        try {
            $userService->deleteUser($id);
            Flight::json(['message' => 'User deleted successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }
}
?>
