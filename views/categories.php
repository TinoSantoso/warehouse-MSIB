<?php include '../templates/header.php'; ?>

<div class="container">
    <!-- Form to Add Category -->
    <form action="categories.php" method="POST" class="mb-4 mt-2">
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3 w-25">Add Category</button>
    </form>

    <!-- Category List -->
    <h2>List of Categories</h2>

    <?php
    require_once '../controllers/CategoryController.php';
    $categoryController = new CategoryController();
    $categories = $categoryController->getAllCategories();
    ?>

    <?php if ($categories->rowCount() > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= ucfirst($row['name']); ?></td>
                        <td>
                            <a href="categories.php?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No categories available</p>
    <?php endif; ?>

    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        // Ensure category creation is successful before redirecting
        if ($categoryController->createCategory($name)) {
            // Redirect after successful form submission to show the new data
            echo "<script>window.location.href='categories.php';</script>";
            exit();
        } else {
            echo "<p class='text-danger'>Failed to create category</p>";
        }
    }

    // Handle deletion
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        if ($categoryController->deleteCategory($id)) {
            // Redirect after successful deletion
            echo "<script>window.location.href='categories.php';</script>";
            exit();
        } else {
            echo "<p class='text-danger'>Failed to delete category</p>";
        }
    }
    ?>

</div>

<?php include '../templates/footer.php'; ?>