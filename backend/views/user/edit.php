<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="update.php?id=<?php echo $user['id']; ?>" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" value=""><br><br>
        <label for="role">Role:</label>
        <input type="text" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" required><br><br>
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required><br><br>
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required><br><br>
        <button type="submit">Update User</button>
    </form>
</body>
</html>
