<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class SavedSearchesController {

    /**
     * @OA\Post(
     *     path="/saved_searches",
     *     summary="Create a new saved search",
     *     description="Creates a new saved search for a user.",
     *     operationId="createSavedSearch",
     *     tags={"SavedSearches"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"user_id", "search_term"},
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="search_term", type="string", example="2-bedroom apartments in city center")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=201,
     *         description="Saved search created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Saved search created successfully")
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
    public static function createSavedSearch() {
        $data = Flight::request()->data->getData();
        $savedSearchesService = new SavedSearchesService();

        try {
            $savedSearchesService->createSavedSearch($data);
            Flight::json(['message' => 'Saved search created successfully'], 201);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/saved_searches/{user_id}",
     *     summary="Get all saved searches for a user",
     *     description="Retrieves all saved searches for a specific user.",
     *     operationId="getSavedSearchesByUserId",
     *     tags={"SavedSearches"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of saved searches",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/SavedSearch"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error retrieving saved searches",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function getSavedSearchesByUserId($user_id) {
        $savedSearchesService = new SavedSearchesService();

        try {
            $savedSearches = $savedSearchesService->getSavedSearchesByUserId($user_id);
            Flight::json($savedSearches);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/saved_searches/{id}",
     *     summary="Update an existing saved search",
     *     description="Updates a saved search by its ID.",
     *     operationId="updateSavedSearch",
     *     tags={"SavedSearches"},
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
     *                 required={"search_term"},
     *                 @OA\Property(property="search_term", type="string", example="updated search term")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Saved search updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Saved search updated successfully")
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
    public static function updateSavedSearch($id) {
        $data = Flight::request()->data->getData();
        $savedSearchesService = new SavedSearchesService();

        try {
            $savedSearchesService->updateSavedSearch($id, $data);
            Flight::json(['message' => 'Saved search updated successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/saved_searches/{id}",
     *     summary="Delete a saved search",
     *     description="Deletes a saved search by its ID.",
     *     operationId="deleteSavedSearch",
     *     tags={"SavedSearches"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Saved search deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Saved search deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Saved search not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function deleteSavedSearch($id) {
        $savedSearchesService = new SavedSearchesService();

        try {
            $savedSearchesService->deleteSavedSearch($id);
            Flight::json(['message' => 'Saved search deleted successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }
}
?>
