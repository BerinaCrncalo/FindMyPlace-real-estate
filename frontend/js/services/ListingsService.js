const API_BASE_URL = 'http://localhost:8000';

export const ListingsService = {
  // Create a new listing
  createListing: async (listingData) => {
    const response = await fetch(`${API_BASE_URL}/listings`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(listingData),
    });
    const data = await response.json();
    if (!response.ok) {
      throw new Error(data.message || 'Failed to create listing');
    }
    return data; // { message: "Listing created successfully" }
  },

  // Get all listings
  getAllListings: async () => {
    const response = await fetch(`${API_BASE_URL}/listings`);
    const data = await response.json();
    if (!response.ok) {
      throw new Error(data.message || 'Failed to fetch listings');
    }
    return data; // array of listings
  },

  // Get listing by ID
  getListingById: async (id) => {
    const response = await fetch(`${API_BASE_URL}/listings/${id}`);
    const data = await response.json();
    if (!response.ok) {
      throw new Error(data.message || `Failed to fetch listing with ID ${id}`);
    }
    return data; // single listing object
  },

  // Update listing by ID
  updateListing: async (id, listingData) => {
    const response = await fetch(`${API_BASE_URL}/listings/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(listingData),
    });
    const data = await response.json();
    if (!response.ok) {
      throw new Error(data.message || `Failed to update listing with ID ${id}`);
    }
    return data; // { message: "Listing updated successfully" }
  },

  // Delete listing by ID
  deleteListing: async (id) => {
    const response = await fetch(`${API_BASE_URL}/listings/${id}`, {
      method: 'DELETE',
    });
    const data = await response.json();
    if (!response.ok) {
      throw new Error(data.message || `Failed to delete listing with ID ${id}`);
    }
    return data; // { message: "Listing deleted successfully" }
  },
};
