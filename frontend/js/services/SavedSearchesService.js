const API_BASE_URL = 'http://localhost:8000';

export const savedSearchesService = {
  createSavedSearch: async (data) => {
    const response = await fetch(`${API_BASE_URL}/saved_searches`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Failed to create saved search');
    }
    return response.json();
  },

  getSavedSearchesByUserId: async (user_id) => {
    const response = await fetch(`${API_BASE_URL}/saved_searches/${user_id}`, {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Failed to fetch saved searches');
    }
    return response.json();
  },

  updateSavedSearch: async (id, data) => {
    const response = await fetch(`${API_BASE_URL}/saved_searches/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Failed to update saved search');
    }
    return response.json();
  },

  deleteSavedSearch: async (id) => {
    const response = await fetch(`${API_BASE_URL}/saved_searches/${id}`, {
      method: 'DELETE',
      headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Failed to delete saved search');
    }
    return response.json();
  },
};
