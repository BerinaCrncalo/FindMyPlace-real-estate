<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class ListingsController {

    /**
     * @OA\Post(
     *     path="/listings",
     *     summary="Create a new listing",
     *     description="Creates a new listing for a user.",
     *     operationId="createListing",
     *     tags={"Listings"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"title", "description", "price", "category_id"},
     *                 @OA\Property(property="title", type="string", example="Beautiful Apartment"),
     *                 @OA\Property(property="description", type="string", example="A lovely two-bedroom apartment."),
     *                 @OA\Property(property="price", type="number", format="float", example=1200.00),
     *                 @OA\Property(property="category_id", type="integer", example=1)
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=201,
     *         description="Listing created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Listing created successfully")
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
    public static function createListing() {
        $data = Flight::request()->data->getData();
        $listingsService = new ListingsService();

        try {
            $listingsService->createListing($data);
            Flight::json(['message' => 'Listing created successfully'], 201);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/listings",
     *     summary="Get all listings",
     *     description="Retrieves a list of all listings.",
     *     operationId="getAllListings",
     *     tags={"Listings"},
     *     @OA\Response(
     *         response=200,
     *         description="List of listings",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Listing"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error retrieving listings",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function getAllListings() {
        $listingsService = new ListingsService();

        try {
            $listings = $listingsService->getAllListings();
            Flight::json($listings);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/listings/{id}",
     *     summary="Get a listing by ID",
     *     description="Retrieves a specific listing by its ID.",
     *     operationId="getListingById",
     *     tags={"Listings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listing details",
     *         @OA\JsonContent(ref="#/components/schemas/Listing")
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
    public static function getListingById($id) {
        $listingsService = new ListingsService();

        try {
            $listing = $listingsService->getListingById($id);
            Flight::json($listing);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/listings/{id}",
     *     summary="Update an existing listing",
     *     description="Updates a listing by its ID.",
     *     operationId="updateListing",
     *     tags={"Listings"},
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
     *                 required={"title", "description", "price", "category_id"},
     *                 @OA\Property(property="title", type="string", example="Updated Apartment"),
     *                 @OA\Property(property="description", type="string", example="A renovated two-bedroom apartment."),
     *                 @OA\Property(property="price", type="number", format="float", example=1300.00),
     *                 @OA\Property(property="category_id", type="integer", example=1)
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Listing updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Listing updated successfully")
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
    public static function updateListing($id) {
        $data = Flight::request()->data->getData();
        $listingsService = new ListingsService();

        try {
            $listingsService->updateListing($id, $data);
            Flight::json(['message' => 'Listing updated successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/listings/{id}",
     *     summary="Delete a listing",
     *     description="Deletes a listing by its ID.",
     *     operationId="deleteListing",
     *     tags={"Listings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listing deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Listing deleted successfully")
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
    public static function deleteListing($id) {
        $listingsService = new ListingsService();

        try {
            $listingsService->deleteListing($id);
            Flight::json(['message' => 'Listing deleted successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }
}
?>
