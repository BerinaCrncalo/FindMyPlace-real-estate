<!DOCTYPE html>
<html>
<head>
    <title>All Listings</title>
</head>
<body>
    <h1>All Listings</h1>
    <ul>
        <?php foreach ($listings as $listing): ?>
            <li>
                ID: <?= htmlspecialchars($listing['id']) ?> |
                Title: <?= htmlspecialchars($listing['title']) ?> |
                Price: <?= htmlspecialchars($listing['price']) ?> |
                Location: <?= htmlspecialchars($listing['location']) ?> |
                <a href="/listings/show/<?= $listing['id'] ?>">View</a> |
                <a href="/listings/edit/<?= $listing['id'] ?>">Edit</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
