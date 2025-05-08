<h1>Create a New Profile</h1>

<form action="store.php" method="POST">
    <label for="user_id">User ID:</label>
    <input type="number" name="user_id" required><br>

    <label for="bio">Bio:</label>
    <textarea name="bio" required></textarea><br>

    <label for="profile_picture_url">Profile Picture URL:</label>
    <input type="text" name="profile_picture_url" required><br>

    <label for="location">Location:</label>
    <input type="text" name="location" required><br>

    <button type="submit">Create Profile</button>
</form>
