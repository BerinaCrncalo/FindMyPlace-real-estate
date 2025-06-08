<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class UserProfilesController {
    private $userProfilesService;

    public function __construct() {
        $this->userProfilesService = new UserProfilesService();
    }

    private function sanitize($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitize'], $input);
        }
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * @OA\Get(
     *     path="/user_profiles/{user_id}",
     *     summary="Get user profile by user ID",
     *     description="Retrieves the profile of a user by their ID.",
     *     operationId="getProfile",
     *     tags={"UserProfiles"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User profile details",
     *         @OA\JsonContent(ref="#/components/schemas/UserProfile")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Profile not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile not found")
     *         )
     *     )
     * )
     */
    public function getProfile($user_id) {
        $user_id = intval($user_id);
        $profile = $this->userProfilesService->getProfileByUserId($user_id);
        if ($profile) {
            echo json_encode($profile);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Profile not found"]);
        }
    }

    /**
     * @OA\Post(
     *     path="/user_profiles",
     *     summary="Create a new user profile",
     *     description="Creates a new user profile.",
     *     operationId="createProfile",
     *     tags={"UserProfiles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "bio", "profile_picture_url", "location"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="bio", type="string", example="A passionate traveler."),
     *             @OA\Property(property="profile_picture_url", type="string", example="http://example.com/pic.jpg"),
     *             @OA\Property(property="location", type="string", example="New York, USA")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Profile created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile created"),
     *             @OA\Property(property="profile_id", type="integer", example=123)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid data provided")
     *         )
     *     )
     * )
     */
    public function createProfile() {
        $data = json_decode(file_get_contents("php://input"), true);
        $data = $this->sanitize($data);

        if ($this->validateProfileData($data)) {
            $profileId = $this->userProfilesService->createProfile($data);
            http_response_code(201);
            echo json_encode(["message" => "Profile created", "profile_id" => $profileId]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Invalid data provided"]);
        }
    }

    /**
     * @OA\Put(
     *     path="/user_profiles/{id}",
     *     summary="Update a user profile",
     *     description="Updates an existing user profile by its ID.",
     *     operationId="updateProfile",
     *     tags={"UserProfiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"bio", "profile_picture_url", "location"},
     *             @OA\Property(property="bio", type="string", example="Updated bio"),
     *             @OA\Property(property="profile_picture_url", type="string", example="http://example.com/updatedpic.jpg"),
     *             @OA\Property(property="location", type="string", example="Los Angeles, USA")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data provided",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid data provided")
     *         )
     *     )
     * )
     */
    public function updateProfile($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $data = $this->sanitize($data);
        $id = intval($id);

        if ($this->validateProfileData($data, false)) {
            $this->userProfilesService->updateProfile($id, $data);
            echo json_encode(["message" => "Profile updated"]);
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Invalid data provided"]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/user_profiles/{id}",
     *     summary="Delete a user profile",
     *     description="Deletes a user profile by its ID.",
     *     operationId="deleteProfile",
     *     tags={"UserProfiles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Profile deleted")
     *         )
     *     )
     * )
     */
    public function deleteProfile($id) {
        $id = intval($id);
        $this->userProfilesService->deleteProfile($id);
        echo json_encode(["message" => "Profile deleted"]);
    }

    private function validateProfileData($data, $isCreate = true) {
        if (!is_array($data)) return false;
        if ($isCreate && empty($data['user_id'])) return false;

        return !empty($data['bio']) &&
               !empty($data['profile_picture_url']) &&
               !empty($data['location']);
    }
}
?>
