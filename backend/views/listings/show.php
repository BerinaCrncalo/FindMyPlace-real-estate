<!DOCTYPE html>
<html>
<head>
    <title>Listing Details</title>
</head>
<body>
    <h1>Listing Details</h1>
    <p>ID: <?= htmlspecialchars($listing['id']) ?></p>
    <p>Title: <?= htmlspecialchars($listing['title']) ?></p>
    <p>Description: <?= htmlspecialchars($listing['description']) ?></p>
    <p>Price: <?= htmlspecialchars($listing['price']) ?></p>
    <p>Location: <?= htmlspecialchars($listing['location']) ?></p>
    <p>Category ID: <?= htmlspecialchars($listing['category_id']) ?></p>
    <p>User ID: <?= htmlspecialchars($listing['user_id']) ?></p>
    <p>Created: <?= htmlspecialchars($listing['created']) ?></p>
</body>
</html>
