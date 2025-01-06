<div class="sidebar">
    <ul>
        <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="add-user.php" class="<?= basename($_SERVER['PHP_SELF']) == 'add-user.php' ? 'active' : '' ?>">Add User</a></li>
        <li><a href="add-category.php" class="<?= basename($_SERVER['PHP_SELF']) == 'add-category.php' ? 'active' : '' ?>">Add Category</a></li>
        <li><a href="list-categories.php" class="<?= basename($_SERVER['PHP_SELF']) == 'list-categories.php' ? 'active' : '' ?>">List Categories</a></li>
        <li><a href="add-book.php" class="<?= basename($_SERVER['PHP_SELF']) == 'add-book.php' ? 'active' : '' ?>">Add Book</a></li>
        <li><a href="list-books.php" class="<?= basename($_SERVER['PHP_SELF']) == 'list-books.php' ? 'active' : '' ?>">List Books</a></li>
        <li><a href="add-author.php" class="<?= basename($_SERVER['PHP_SELF']) == 'add-author.php' ? 'active' : '' ?>">Add Author</a></li>
        <li><a href="list-authors.php" class="<?= basename($_SERVER['PHP_SELF']) == 'list-authors.php' ? 'active' : '' ?>">List Authors</a></li>
        <li><a href="add-borrowing.php" class="<?= basename($_SERVER['PHP_SELF']) == 'add-borrowing.php' ? 'active' : '' ?>">Add Borrowing</a></li>
        <li><a href="borrow-details.php" class="<?= basename($_SERVER['PHP_SELF']) == 'borrow-details.php' ? 'active' : '' ?>">Borrow Details</a></li>
        <li><a href="../user-profile.php">User Profile</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</div>