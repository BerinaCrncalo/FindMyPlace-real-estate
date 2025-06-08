<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class UserController {

    // Sanitize input to prevent XSS
    private static function sanitize($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitize'], $input);
        }
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

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

        // Sanitize inputs to prevent XSS
        $data = self::sanitize($data);

        // Validate required fields and formats
        if (empty($data['username']) || strlen($data['username']) < 3) {
            Flight::json(['message' => 'Username is required and must be at least 3 characters long.'], 400);
            return;
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Flight::json(['message' => 'Valid email is required.'], 400);
            return;
        }
        if (empty($data['password']) || strlen($data['password']) < 6) {
            Flight::json(['message' => 'Password is required and must be at least 6 characters long.'], 400);
            return;
        }

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
        // Sanitize ID (cast to int to avoid injection)
        $id = intval($id);

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

        // Sanitize inputs
        $data = self::sanitize($data);
        $id = intval($id);

        // Validate required fields
        if (empty($data['username']) || strlen($data['username']) < 3) {
            Flight::json(['message' => 'Username is required and must be at least 3 characters long.'], 400);
            return;
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Flight::json(['message' => 'Valid email is required.'], 400);
            return;
        }
        if (empty($data['password']) || strlen($data['password']) < 6) {
            Flight::json(['message' => 'Password is required and must be at least 6 characters long.'], 400);
            return;
        }

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
        $id = intval($id);

        $userService = new UserService();

        try {
            $userService->deleteUser($id);
            Flight::json(['message' => 'User deleted successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/users/login",
     *     summary="Authenticate user",
     *     description="Authenticates a user and returns their data (excluding password).",
     *     operationId="loginUser",
     *     tags={"Users"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"email", "password"},
     *                 @OA\Property(property="email", type="string", example="john_doe@example.com"),
     *                 @OA\Property(property="password", type="string", example="password123")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="User authenticated",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public static function loginUser() {
        $data = Flight::request()->data->getData();

        // Sanitize inputs
        $data = self::sanitize($data);

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Flight::json(['message' => 'Valid email is required.'], 400);
            return;
        }
        if (empty($data['password'])) {
            Flight::json(['message' => 'Password is required.'], 400);
            return;
        }

        $userService = new UserService();

        try {
            $user = $userService->authenticateUser($data['email'], $data['password']);
            Flight::json($user, 200);
        } catch (Exception $e) {
            Flight::json(['message' => 'Invalid credentials'], 401);
        }
    }
}
