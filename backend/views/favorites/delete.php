<!DOCTYPE html>
<html>
<head>
    <title>Remove Favorite</title>
</head>
<body>
    <h1>Remove Favorite</h1>
    <form action="/favorites" method="post" onsubmit="this._method.value='DELETE'">
        <label>User ID:</label>
        <input type="text" name="user_id" required><br>

        <label>Listing ID:</label>
        <input type="text" name="listings_id" required><br>

        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" value="Remove">
    </form>
</body>
</html>
