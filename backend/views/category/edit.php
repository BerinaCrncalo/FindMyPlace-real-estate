<h1>Edit Category</h1>
<form action="/categories/edit/<?php echo $category['id']; ?>" method="post">
    <label for="name">Category Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $category['name']; ?>" required>
    <button type="submit">Update Category</button>
</form>
<a href="/categories">Cancel</a>
