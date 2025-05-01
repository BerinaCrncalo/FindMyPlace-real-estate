<!DOCTYPE html>
<html>
<head>
    <title>Add to Favorites</title>
</head>
<body>
    <h1>Add Listing to Favorites</h1>
    <form action="/favorites" method="post">
        <label>User ID:</label>
        <input type="text" name="user_id" required><br>

        <label>Listing ID:</label>
        <input type="text" name="listings_id" required><br>

        <input type="submit" value="Add to Favorites">
    </form>
</body>
</html>
