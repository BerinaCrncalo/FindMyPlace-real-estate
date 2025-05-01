<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class ListingImageController {

    /**
     * @OA\Post(
     *     path="/listing_images",
     *     summary="Add an image to a listing",
     *     description="Adds an image to a specific listing.",
     *     operationId="addImageToListing",
     *     tags={"ListingImages"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"listing_id", "image_url"},
     *                 @OA\Property(property="listing_id", type="integer", example=101),
     *                 @OA\Property(property="image_url", type="string", example="http://example.com/image.jpg")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=201,
     *         description="Image added to listing",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Image added to listing")
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
    public static function addImageToListing() {
        $data = Flight::request()->data->getData();
        $listingImageService = new ListingImageService();

        try {
            $listingImageService->addImageToListing($data);
            Flight::json(['message' => 'Image added to listing'], 201);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/listing_images",
     *     summary="Get all listing images",
     *     description="Returns a list of all images for all listings.",
     *     operationId="getAllImages",
     *     tags={"ListingImages"},
     *     @OA\Response(
     *         response=200,
     *         description="List of listing images",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ListingImage"))
     *     )
     * )
     */
    public static function getAllImages() {
        $listingImageService = new ListingImageService();

        try {
            $images = $listingImageService->getAllImages();
            Flight::json($images);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/listing_images/{id}",
     *     summary="Get image by ID",
     *     description="Returns a single image by its ID.",
     *     operationId="getImageById",
     *     tags={"ListingImages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Listing image details",
     *         @OA\JsonContent(ref="#/components/schemas/ListingImage")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Image not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function getImageById($id) {
        $listingImageService = new ListingImageService();

        try {
            $image = $listingImageService->getImageById($id);
            Flight::json($image);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/listing_images/{id}",
     *     summary="Update an image",
     *     description="Updates the image for a listing by its ID.",
     *     operationId="updateImage",
     *     tags={"ListingImages"},
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
     *                 required={"image_url"},
     *                 @OA\Property(property="image_url", type="string", example="http://example.com/updated-image.jpg")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Image updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Image updated successfully")
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
    public static function updateImage($id) {
        $data = Flight::request()->data->getData();
        $listingImageService = new ListingImageService();

        try {
            $listingImageService->updateImage($id, $data);
            Flight::json(['message' => 'Image updated successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/listing_images/{id}",
     *     summary="Delete an image",
     *     description="Deletes an image by its ID.",
     *     operationId="deleteImage",
     *     tags={"ListingImages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Image deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Image deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Image not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function deleteImage($id) {
        $listingImageService = new ListingImageService();

        try {
            $listingImageService->deleteImage($id);
            Flight::json(['message' => 'Image deleted successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }
}
?>
