<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>
    <h1>Create New User</h1>
    <form action="store.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        <label for="role">Role:</label>
        <input type="text" name="role" required><br><br>
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required><br><br>
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" required><br><br>
        <button type="submit">Create User</button>
    </form>
</body>
</html>
