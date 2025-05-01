<?php
class SavedSearchesService {
    private $savedSearchesDao;

    public function __construct() {
        $this->savedSearchesDao = new SavedSearchesDao();
    }

    // Create a new saved search
    public function createSavedSearch($data) {
        // Validation logic
        if (empty($data['search_query'])) {
            throw new Exception("Search query is required.");
        }

        // Call DAO to insert the saved search
        $this->savedSearchesDao->create($data);
    }

    // Get all saved searches for a user
    public function getSavedSearchesByUserId($user_id) {
        return $this->savedSearchesDao->getByUserId($user_id);
    }

    // Update an existing saved search
    public function updateSavedSearch($id, $data) {
        // Validation logic
        if (empty($data['search_query'])) {
            throw new Exception("Search query is required.");
        }

        // Call DAO to update the saved search
        $this->savedSearchesDao->update($id, $data);
    }

    // Delete a saved search
    public function deleteSavedSearch($id) {
        $this->savedSearchesDao->delete($id);
    }
}
?>