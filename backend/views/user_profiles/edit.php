<h1>Edit Profile: <?php echo $profile['user_id']; ?></h1>

<form action="update.php?id=<?php echo $profile['id']; ?>" method="POST">
    <label for="user_id">User ID:</label>
    <input type="number" name="user_id" value="<?php echo $profile['user_id']; ?>" required><br>

    <label for="bio">Bio:</label>
    <textarea name="bio" required><?php echo $profile['bio']; ?></textarea><br>

    <label for="profile_picture_url">Profile Picture URL:</label>
    <input type="text" name="profile_picture_url" value="<?php echo $profile['profile_picture_url']; ?>" required><br>

    <label for="location">Location:</label>
    <input type="text" name="location" value="<?php echo $profile['location']; ?>" required><br>

    <button type="submit">Update Profile</button>
</form>
