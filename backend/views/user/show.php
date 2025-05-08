<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
</head>
<body>
    <h1>User Details</h1>
    <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
    <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
    <p><strong>Created At:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
    <a href="edit.php?id=<?php echo $user['id']; ?>">Edit</a> | 
    <a href="delete.php?id=<?php echo $user['id']; ?>">Delete</a>
</body>
</html>
