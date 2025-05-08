<!DOCTYPE html>
<html>
<head>
    <title>Edit Saved Search</title>
</head>
<body>
    <h1>Edit Saved Search</h1>
    <form action="/saved_searches/<?= $saved_search['id'] ?>" method="post">
        <input type="hidden" name="_method" value="PUT">

        <label>Search Query:</label><br>
        <input type="text" name="search_query" value="<?= htmlspecialchars($saved_search['search_query']) ?>" required><br>

        <input type="submit" value="Update Search">
    </form>
</body>
</html>
