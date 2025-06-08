<?php
/**
 * @OA\Info(title="FindMyPlace API", version="1.0")
 */
class CategoryController {

    /**
     * @OA\Post(
     *     path="/categories",
     *     summary="Create a new category",
     *     description="Creates a new category with provided data.",
     *     operationId="createCategory",
     *     tags={"Categories"},
     *     requestBody={
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"name"},
     *                 @OA\Property(property="name", type="string", example="New Category")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=201,
     *         description="Category created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Category created successfully"),
     *             @OA\Property(property="category_id", type="integer", example=1)
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
    
    // Sanitize string inputs to prevent XSS
    private static function sanitizeInput(string $input): string {
        return htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }

    // Validate ID parameter (must be positive integer)
    private static function validateId($id): int {
        if (!is_numeric($id) || intval($id) <= 0) {
            throw new Exception("Invalid ID");
        }
        return intval($id);
    }

    public static function createCategory() {
        $data = Flight::request()->data->getData();

        try {
            // Validate required field
            if (empty($data['name'])) {
                throw new Exception("Name is required");
            }
            // Sanitize input to prevent XSS
            $data['name'] = self::sanitizeInput($data['name']);

            $categoryService = new CategoryService();
            $categoryId = $categoryService->createCategory($data);

            Flight::json(['message' => 'Category created successfully', 'category_id' => $categoryId], 201);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/categories",
     *     summary="Get all categories",
     *     description="Returns a list of all categories.",
     *     operationId="getAllCategories",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="List of categories",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Category"))
     *     )
     * )
     */
    public static function getAllCategories() {
        $categoryService = new CategoryService();
        $categories = $categoryService->getAllCategories();
        Flight::json($categories);
    }

    /**
     * @OA\Get(
     *     path="/categories/{id}",
     *     summary="Get category by ID",
     *     description="Returns a single category by its ID.",
     *     operationId="getCategoryById",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category details",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function getCategoryById($id) {
        try {
            $id = self::validateId($id);

            $categoryService = new CategoryService();
            $category = $categoryService->getCategoryById($id);
            Flight::json($category);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/categories/{id}",
     *     summary="Update category",
     *     description="Updates an existing category by its ID.",
     *     operationId="updateCategory",
     *     tags={"Categories"},
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
     *                 required={"name"},
     *                 @OA\Property(property="name", type="string", example="Updated Category")
     *             )
     *         )
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Category updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Category updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Category not found or invalid data",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function updateCategory($id) {
        $data = Flight::request()->data->getData();

        try {
            $id = self::validateId($id);

            if (empty($data['name'])) {
                throw new Exception("Name is required");
            }
            $data['name'] = self::sanitizeInput($data['name']);

            $categoryService = new CategoryService();
            $categoryService->updateCategory($id, $data);

            Flight::json(['message' => 'Category updated successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/categories/{id}",
     *     summary="Delete category",
     *     description="Deletes a category by its ID.",
     *     operationId="deleteCategory",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Category deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error message")
     *         )
     *     )
     * )
     */
    public static function deleteCategory($id) {
        try {
            $id = self::validateId($id);

            $categoryService = new CategoryService();
            $categoryService->deleteCategory($id);

            Flight::json(['message' => 'Category deleted successfully'], 200);
        } catch (Exception $e) {
            Flight::json(['message' => $e->getMessage()], 400);
        }
    }
}
?>
