<!DOCTYPE html>
<html>
<head>
    <title>Add Listing Image</title>
</head>
<body>
    <h1>Add Listing Image</h1>
    <form action="/listing_images" method="post">
        <label>Image URL:</label>
        <input type="text" name="image_url" required><br>

        <label>Listing ID:</label>
        <input type="text" name="listing_id" required><br>

        <input type="submit" value="Add Image">
    </form>
</body>
</html>
