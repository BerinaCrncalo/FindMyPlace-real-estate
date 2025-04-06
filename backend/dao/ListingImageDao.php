<?php

require_once 'BaseDao.php';

class ListingImageDao extends BaseDao {
    public function __construct() {
        parent::__construct('listing_images'); 
    }

    public function create($listingImage) {
        // Check if the listing exists 
        $stmt = $this->connection->prepare("SELECT id FROM listings WHERE id = :listing_id");
        $stmt->bindParam(':listing_id', $listingImage['listing_id']);
        $stmt->execute();
        $listing = $stmt->fetch();
    
        if (!$listing) {
            throw new Exception("Listing with ID " . $listingImage['listing_id'] . " does not exist.");
        }
    
        // Insert into the listing_images table
        $stmt = $this->connection->prepare(
            "INSERT INTO listing_images (image_url, listing_id, listings_id) VALUES (:image_url, :listing_id, :listings_id)"
        );
        $stmt->bindParam(':image_url', $listingImage['image_url']);
        $stmt->bindParam(':listing_id', $listingImage['listing_id']);
        $stmt->bindParam(':listings_id', $listingImage['listings_id']); // Assuming listings_id is being provided
        $stmt->execute();
    }
    

    public function getAll() {
        $stmt = $this->connection->query("SELECT * FROM listing_images");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM listing_images WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function update($id, $listingImage) {
        $stmt = $this->connection->prepare(
            "UPDATE listing_images SET image_url = :image_url, listing_id = :listing_id WHERE id = :id"
        );
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':image_url', $listingImage['image_url']);
        $stmt->bindParam(':listing_id', $listingImage['listing_id']);
        $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM listing_images WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
