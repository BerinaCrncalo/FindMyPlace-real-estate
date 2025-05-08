<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class FavoritesController {

    /**
     * @OA\Post(
     *     path="/favorites",
     *     summary="Add a listing to favorites",
     *     description="Adds a listing to the user's favorites list.",
     *     operationId="addToFavorites",
     *     tags={"Favorites"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"user_id", "listing_id"},
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="listing_id", type="integer", example=101)
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=201,
     *         description="Listing added to favorites",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Listing added to favorites"),
     *             @OA\Property(property="favorite_id", type="integer", example=1)
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
    public static function addToFavorites() {
        $data = Flight::request()->data->getData();
        $favoritesService = new FavoritesService();

        try {
            $favoriteId = $favoritesService->addToFavorites($data);
            Flight::json(['message' => 'Listing added to favorites', 'favorite_id' => $favoriteId], 201);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/favorites/{user_id}",
     *     summary="Get all favorites for a user",
     *     description="Returns a list of all favorites for a specific user.",
     *     operationId="getFavoritesByUserId",
     *     tags={"Favorites"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of favorites",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Favorite"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Favorites not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function getFavoritesByUserId($user_id) {
        $favoritesService = new FavoritesService();

        try {
            $favorites = $favoritesService->getFavoritesByUserId($user_id);
            Flight::json($favorites);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/favorites/{id}",
     *     summary="Remove a listing from favorites",
     *     description="Removes a listing from the user's favorites list.",
     *     operationId="removeFromFavorites",
     *     tags={"Favorites"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listing removed from favorites",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Listing removed from favorites")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Listing not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function removeFromFavorites($id) {
        $favoritesService = new FavoritesService();

        try {
            $favoritesService->removeFromFavorites($id);
            Flight::json(['message' => 'Listing removed from favorites'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }
}
?>
