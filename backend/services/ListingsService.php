<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class ListingsService {
    private $listingsDao;

    public function __construct() {
        $this->listingsDao = new ListingsDao();
    }

    /**
     * @OA\Post(
     *     path="/listings",
     *     summary="Create a new listing",
     *     description="Creates a new listing with title, description, price, and location.",
     *     operationId="createListing",
     *     tags={"Listings"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"title", "description", "price", "location"},
     *                 @OA\Property(property="title", type="string", example="Cozy Apartment in the City"),
     *                 @OA\Property(property="description", type="string", example="A cozy apartment located in the city center."),
     *                 @OA\Property(property="price", type="number", format="float", example=1200.50),
     *                 @OA\Property(property="location", type="string", example="Sarajevo")
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
    public function createListing($data) {
        if (empty($data['title']) || empty($data['description']) || empty($data['price']) || empty($data['location'])) {
            throw new Exception("Title, description, price, and location are required.");
        }

        $this->listingsDao->create($data);
    }

    /**
     * @OA\Get(
     *     path="/listings",
     *     summary="Get all listings",
     *     description="Returns a list of all listings.",
     *     operationId="getAllListings",
     *     tags={"Listings"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all listings",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Listing"))
     *     )
     * )
     */
    public function getAllListings() {
        return $this->listingsDao->getAll();
    }

    /**
     * @OA\Get(
     *     path="/listings/{id}",
     *     summary="Get listing by ID",
     *     description="Returns a single listing by its ID.",
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
     *         response=404,
     *         description="Listing not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Listing not found")
     *         )
     *     )
     * )
     */
    public function getListingById($id) {
        return $this->listingsDao->getById($id);
    }

    /**
     * @OA\Put(
     *     path="/listings/{id}",
     *     summary="Update an existing listing",
     *     description="Updates an existing listing with the given ID.",
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
     *                 required={"title", "description", "price", "location"},
     *                 @OA\Property(property="title", type="string", example="Updated Cozy Apartment"),
     *                 @OA\Property(property="description", type="string", example="Updated description of the apartment."),
     *                 @OA\Property(property="price", type="number", format="float", example=1300.00),
     *                 @OA\Property(property="location", type="string", example="Sarajevo")
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
    public function updateListing($id, $data) {
        if (empty($data['title']) || empty($data['description']) || empty($data['price']) || empty($data['location'])) {
            throw new Exception("Title, description, price, and location are required.");
        }

        $this->listingsDao->update($id, $data);
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
     *         response=404,
     *         description="Listing not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Listing not found")
     *         )
     *     )
     * )
     */
    public function deleteListing($id) {
        $this->listingsDao->delete($id);
    }
}
?>
