<?php
class ListingImageService {
    private $listingImageDao;

    public function __construct() {
        $this->listingImageDao = new ListingImageDao();
    }

    // Add an image to a listing
    public function addImageToListing($data) {
        // Validation logic
        if (empty($data['image_url']) || empty($data['listing_id'])) {
            throw new Exception("Image URL and Listing ID are required.");
        }

        // Call DAO to insert the image
        $this->listingImageDao->create($data);
    }

    // Get all listing images
    public function getAllImages() {
        return $this->listingImageDao->getAll();
    }

    // Get a single listing image by ID
    public function getImageById($id) {
        return $this->listingImageDao->getById($id);
    }

    // Update an existing listing image
    public function updateImage($id, $data) {
        if (empty($data['image_url']) || empty($data['listing_id'])) {
            throw new Exception("Image URL and Listing ID are required.");
        }

        $this->listingImageDao->update($id, $data);
    }

    // Delete a listing image
    public function deleteImage($id) {
        $this->listingImageDao->delete($id);
    }
}
?>