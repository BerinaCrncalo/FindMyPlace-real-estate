<?php
class FavoritesService {
    private $favoritesDao;

    public function __construct() {
        $this->favoritesDao = new FavoritesDao();
    }

    // Add a listing to favorites
    public function addToFavorites($data) {
        // Validation logic
        if (empty($data['user_id']) || empty($data['listings_id'])) {
            throw new Exception("User ID and Listing ID are required.");
        }

        // Call DAO to add the favorite
        return $this->favoritesDao->create($data);
    }

    // Get all favorites for a specific user
    public function getFavoritesByUserId($user_id) {
        if (empty($user_id)) {
            throw new Exception("User ID is required.");
        }

        return $this->favoritesDao->getByUserId($user_id);
    }

    // Remove a listing from favorites
    public function removeFromFavorites($id) {
        if (empty($id)) {
            throw new Exception("Favorite ID is required.");
        }

        return $this->favoritesDao->delete($id);
    }
}
?>