const API_BASE_URL = 'http://localhost:8000';

export const ContactMessageService = {
  // Create a new contact message
  createContactMessage: async (userId, message) => {
    const response = await fetch(`${API_BASE_URL}/contact_messages`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ user_id: userId, message }),
    });
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to create contact message');
    }
    return response.json();
  },

  // Get all contact messages
  getAllContactMessages: async () => {
    const response = await fetch(`${API_BASE_URL}/contact_messages`);
    if (!response.ok) {
      throw new Error('Failed to fetch contact messages');
    }
    return response.json();
  },

  // Get a contact message by ID
  getContactMessageById: async (id) => {
    const response = await fetch(`${API_BASE_URL}/contact_messages/${id}`);
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Contact message not found');
    }
    return response.json();
  },

  // Update a contact message by ID
  updateContactMessage: async (id, message) => {
    const response = await fetch(`${API_BASE_URL}/contact_messages/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ message }),
    });
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to update contact message');
    }
    return response.json();
  },

  // Delete a contact message by ID
  deleteContactMessage: async (id) => {
    const response = await fetch(`${API_BASE_URL}/contact_messages/${id}`, {
      method: 'DELETE',
    });
    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || 'Failed to delete contact message');
    }
    return response.json();
  },
};
