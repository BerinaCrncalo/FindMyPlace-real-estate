<!DOCTYPE html>
<html>
<head>
    <title>Listing Images</title>
</head>
<body>
    <h1>All Listing Images</h1>
    <ul>
        <?php foreach ($images as $img): ?>
            <li>
                ID: <?= htmlspecialchars($img['id']) ?> |
                Image URL: <?= htmlspecialchars($img['image_url']) ?> |
                Listing ID: <?= htmlspecialchars($img['listing_id']) ?> |
                <a href="/listing_images/show/<?= $img['id'] ?>">View</a> |
                <a href="/listing_images/edit/<?= $img['id'] ?>">Edit</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
