const API_BASE_URL = 'http://localhost:8000';

export const FavoritesService = {
  // Add a listing to favorites
  addToFavorites: async (userId, listingId) => {
    const response = await fetch(`${API_BASE_URL}/favorites`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ user_id: userId, listing_id: listingId }),
    });
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to add listing to favorites');
    }
    return response.json();
  },

  // Get all favorites for a user
  getFavoritesByUserId: async (userId) => {
    const response = await fetch(`${API_BASE_URL}/favorites/${userId}`);
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to fetch favorites');
    }
    return response.json();
  },

  // Remove a listing from favorites by favorite ID
  removeFromFavorites: async (favoriteId) => {
    const response = await fetch(`${API_BASE_URL}/favorites/${favoriteId}`, {
      method: 'DELETE',
    });
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to remove listing from favorites');
    }
    return response.json();
  },
};
