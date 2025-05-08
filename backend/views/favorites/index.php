<!DOCTYPE html>
<html>
<head>
    <title>User Favorites</title>
</head>
<body>
    <h1>Favorites for User</h1>
    <ul>
        <?php foreach ($favorites as $fav): ?>
            <li>Listing ID: <?= htmlspecialchars($fav['listings_id']) ?> (User ID: <?= htmlspecialchars($fav['user_id']) ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
