const API_BASE_URL = 'http://localhost:8000';

export const userProfilesService = {
  getProfile: async (user_id) => {
    const response = await fetch(`${API_BASE_URL}/user_profiles/${user_id}`, {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Failed to fetch profile');
    }
    return response.json();
  },

  createProfile: async (data) => {
    const response = await fetch(`${API_BASE_URL}/user_profiles`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Failed to create profile');
    }
    return response.json();
  },

  updateProfile: async (id, data) => {
    const response = await fetch(`${API_BASE_URL}/user_profiles/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Failed to update profile');
    }
    return response.json();
  },

  deleteProfile: async (id) => {
    const response = await fetch(`${API_BASE_URL}/user_profiles/${id}`, {
      method: 'DELETE',
      headers: { 'Content-Type': 'application/json' },
    });
    if (!response.ok) {
      const error = await response.json();
      throw new Error(error.message || 'Failed to delete profile');
    }
    return response.json();
  },
};
