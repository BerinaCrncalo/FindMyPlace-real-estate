<!DOCTYPE html>
<html>
<head>
    <title>Saved Searches</title>
</head>
<body>
    <h1>Saved Searches for User <?= htmlspecialchars($user_id) ?></h1>
    <ul>
        <?php foreach ($saved_searches as $search): ?>
            <li>
                ID: <?= htmlspecialchars($search['id']) ?> |
                Query: <?= htmlspecialchars($search['search_query']) ?> |
                Created At: <?= htmlspecialchars($search['created_at']) ?> |
                <a href="/saved_searches/edit/<?= $search['id'] ?>">Edit</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
