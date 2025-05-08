<!DOCTYPE html>
<html>
<head>
    <title>Create Saved Search</title>
</head>
<body>
    <h1>Create New Saved Search</h1>
    <form action="/saved_searches" method="post">
        <label>User ID:</label><br>
        <input type="number" name="user_id" required><br>

        <label>Search Query:</label><br>
        <input type="text" name="search_query" required><br>

        <input type="submit" value="Save Search">
    </form>
</body>
</html>
