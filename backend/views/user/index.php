<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
</head>
<body>
    <h1>User List</h1>
    <a href="create.php">Create New User</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Full Name</th>
            <th>Phone Number</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <a href="show.php?id=<?php echo $user['id']; ?>">View</a> | 
                    <a href="edit.php?id=<?php echo $user['id']; ?>">Edit</a> | 
                    <a href="delete.php?id=<?php echo $user['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
