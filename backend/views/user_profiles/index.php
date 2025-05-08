<h1>User Profiles</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Bio</th>
        <th>Profile Picture</th>
        <th>Location</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($userProfiles as $profile): ?>
        <tr>
            <td><?php echo $profile['id']; ?></td>
            <td><?php echo $profile['user_id']; ?></td>
            <td><?php echo $profile['bio']; ?></td>
            <td><img src="<?php echo $profile['profile_picture_url']; ?>" alt="Profile Picture" width="50"></td>
            <td><?php echo $profile['location']; ?></td>
            <td>
                <a href="show.php?id=<?php echo $profile['id']; ?>">Show</a>
                <a href="edit.php?id=<?php echo $profile['id']; ?>">Edit</a>
                <a href="delete.php?id=<?php echo $profile['id']; ?>" onclick="return confirm('Are you sure you want to delete this profile?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="create.php">Create New Profile</a>
