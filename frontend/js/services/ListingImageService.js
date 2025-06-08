const API_BASE_URL = 'http://localhost:8000';

export const ListingImageService = {
  // Add an image to a listing
  addImageToListing: async (listingId, imageUrl) => {
    const response = await fetch(`${API_BASE_URL}/listing_images`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ listing_id: listingId, image_url: imageUrl }),
    });
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to add image to listing');
    }
    return response.json();
  },

  // Get all listing images
  getAllImages: async () => {
    const response = await fetch(`${API_BASE_URL}/listing_images`);
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to fetch listing images');
    }
    return response.json();
  },

  // Get image by ID
  getImageById: async (id) => {
    const response = await fetch(`${API_BASE_URL}/listing_images/${id}`);
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to fetch image');
    }
    return response.json();
  },

  // Update image by ID
  updateImage: async (id, imageUrl) => {
    const response = await fetch(`${API_BASE_URL}/listing_images/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ image_url: imageUrl }),
    });
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to update image');
    }
    return response.json();
  },

  // Delete image by ID
  deleteImage: async (id) => {
    const response = await fetch(`${API_BASE_URL}/listing_images/${id}`, {
      method: 'DELETE',
    });
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to delete image');
    }
    return response.json();
  },
};
