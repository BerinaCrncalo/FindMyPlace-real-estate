<!DOCTYPE html>
<html>
<head>
    <title>Create Listing</title>
</head>
<body>
    <h1>Create New Listing</h1>
    <form action="/listings" method="post">
        <label>Title:</label><br>
        <input type="text" name="title" required><br>

        <label>Description:</label><br>
        <textarea name="description" required></textarea><br>

        <label>Price:</label><br>
        <input type="number" name="price" required><br>

        <label>Location:</label><br>
        <input type="text" name="location" required><br>

        <label>Category ID:</label><br>
        <input type="number" name="category_id" required><br>

        <label>User ID:</label><br>
        <input type="number" name="user_id" required><br>

        <input type="submit" value="Create Listing">
    </form>
</body>
</html>
