<!DOCTYPE html>
<html>
<head>
    <title>Listing Image Details</title>
</head>
<body>
    <h1>Listing Image Details</h1>
    <p>ID: <?= htmlspecialchars($image['id']) ?></p>
    <p>Image URL: <a href="<?= htmlspecialchars($image['image_url']) ?>" target="_blank"><?= htmlspecialchars($image['image_url']) ?></a></p>
    <p>Listing ID: <?= htmlspecialchars($image['listing_id']) ?></p>
</body>
</html>
