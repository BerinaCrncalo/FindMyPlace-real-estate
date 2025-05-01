<h1>Categories</h1>
<a href="/categories/create">Create New Category</a>
<ul>
    <?php foreach ($categories as $category): ?>
        <li>
            <?php echo $category['name']; ?>
            <a href="/categories/edit/<?php echo $category['id']; ?>">Edit</a>
            <a href="/categories/delete/<?php echo $category['id']; ?>">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>
