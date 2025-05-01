<?php
class CategoryService {
    private $categoryDao;

    public function __construct() {
        $this->categoryDao = new CategoryDao();
    }

    // Create a new category
    public function createCategory($data) {
        // Validation logic
        if (empty($data['name'])) {
            throw new Exception("Category name is required.");
        }
        if (strlen($data['name']) < 3) {
            throw new Exception("Category name must be at least 3 characters long.");
        }

        // Call DAO to insert the category
        $categoryId = $this->categoryDao->create($data);
        return $categoryId;
    }

    // Get all categories
    public function getAllCategories() {
        return $this->categoryDao->getAll();
    }

    // Get category by ID
    public function getCategoryById($id) {
        if (empty($id)) {
            throw new Exception("Category ID is required.");
        }
        return $this->categoryDao->getById($id);
    }

    // Update category
    public function updateCategory($id, $data) {
        // Validation logic
        if (empty($data['name'])) {
            throw new Exception("Category name is required.");
        }

        $this->categoryDao->update($id, $data);
    }

    // Delete category
    public function deleteCategory($id) {
        if (empty($id)) {
            throw new Exception("Category ID is required.");
        }

        $this->categoryDao->delete($id);
    }
}
?>