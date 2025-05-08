<!DOCTYPE html>
<html>
<head>
    <title>Edit Listing</title>
</head>
<body>
    <h1>Edit Listing</h1>
    <form action="/listings/<?= $listing['id'] ?>" method="post">
        <input type="hidden" name="_method" value="PUT">

        <label>Title:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($listing['title']) ?>" required><br>

        <label>Description:</label><br>
        <textarea name="description" required><?= htmlspecialchars($listing['description']) ?></textarea><br>

        <label>Price:</label><br>
        <input type="number" name="price" value="<?= htmlspecialchars($listing['price']) ?>" required><br>

        <label>Location:</label><br>
        <input type="text" name="location" value="<?= htmlspecialchars($listing['location']) ?>" required><br>

        <label>Category ID:</label><br>
        <input type="number" name="category_id" value="<?= htmlspecialchars($listing['category_id']) ?>" required><br>

        <label>User ID:</label><br>
        <input type="number" name="user_id" value="<?= htmlspecialchars($listing['user_id']) ?>" required><br>

        <input type="submit" value="Update Listing">
    </form>
</body>
</html>
