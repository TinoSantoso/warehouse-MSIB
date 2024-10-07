<?php include '../templates/header.php'; ?>

<div class="container">

    <?php
        require_once '../controllers/ProductController.php';
        $productController = new ProductController();
        // Initialize variables for the form
        $name = '';
        $category_id = '';
        $warehouse_id = '';
        $price = '';
        $stock = '';
        $editMode = false;
        $productId = null;

        // Check if editing an existing product
        if (isset($_GET['edit'])) {
            $productId = $_GET['edit'];
            $product = $productController->getProductById($productId);
            
            if ($product) {
                $name = $product['name'];
                $category_id = $product['category_id'];
                $warehouse_id = $product['warehouse_id'];
                $price = $product['price'];
                $stock = $product['stock'];
                $editMode = true;  // Set to true to indicate we are editing
            }
        }
    ?>

    <!-- Form to Add Product -->
    <form action="products.php" method="POST" class="mb-4 mt-2" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $productId; ?>">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- Categories Dropdown -->
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <?php
                        require_once '../controllers/CategoryController.php';
                        $categoryController = new CategoryController();
                        $categories = $categoryController->getAllCategories();
        
                        if ($categories->rowCount() > 0) {
                            echo "<option value=''>Choose a category</option>";
                            // Loop through and display categories
                            while ($row = $categories->fetch(PDO::FETCH_ASSOC)) {
                                $category_name = ucfirst($row['name']);
                                $attribute = ($row['id'] == $category_id) ? 'selected' : '';
                                echo "<option value='{$row['id']}' {$attribute}>{$category_name}</option>";
                            }
                        } else {
                            // No categories available
                            echo "<option disabled>No categories available</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Warehouses Dropdown -->
                <div class="form-group">
                    <label for="warehouse_id">Warehouse</label>
                    <select class="form-control" id="warehouse_id" name="warehouse_id" required>
                        <?php
                        require_once '../controllers/WarehouseController.php';
                        $warehouseController = new WarehouseController();
                        $warehouses = $warehouseController->getAllWarehouses();
        
                        if ($warehouses->rowCount() > 0) {
                            echo "<option value=''>Choose a warehouse</option>";
                            // Loop through and display warehouses
                            while ($row = $warehouses->fetch(PDO::FETCH_ASSOC)) {
                                $warehouse_name = ucfirst($row['name']);
                                $attribute = ($row['id'] == $warehouse_id) ? 'selected' : '';
                                echo "<option value='{$row['id']}' {$attribute}>{$warehouse_name}</option>";
                            }
                        } else {
                            // No warehouses available
                            echo "<option disabled>No warehouses available</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="price">Price</label>
                    <div class="input-group">
                        <div class="input-group-text">IDR</div>
                        <input type="text" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="stock">Stock</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $stock; ?>" required>
                        <div class="input-group-text">Kg</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="product_images">Product Images</label>
            <input type="file" name="product_images[]" id="product_images" multiple class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary mt-3 w-25">
            <?= $editMode ? 'Update Product' : 'Add Product'; ?>
        </button>
    </form>

    <!-- Product List -->
    <h2>List of Products</h2>

    <?php 
    $products = $productController->getAllProducts();

    if ($products->rowCount() > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Warehouse</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= ucfirst($row['product_name']); ?></td>
                        <td><?= $row['category_name']; ?></td>
                        <td><?= $row['warehouse_name']; ?></td>
                        <td><?= 'Rp ' . number_format($row['price'], 0, ',', '.'); ?></td>
                        <td><?= $row['stock']. ' Kg'; ?></td>
                        <td>
                            <a href="products.php?edit=<?= $row['id']; ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="products.php?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No products available</p>
    <?php endif; ?>

    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $warehouse_id = $_POST['warehouse_id'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Update product
            $productId = $_POST['id'];
            if ($productController->updateProduct($productId, $name, $category_id, $warehouse_id, $price, $stock)) {
                echo "<script>window.location.href='products.php';</script>";
                exit();
            } else {
                echo "<p class='text-danger'>Failed to update product.</p>";
            }
        } else {
            // Create new product
            if ($productController->createProduct($name, $category_id, $warehouse_id, $price, $stock)) {
                echo "<script>window.location.href='products.php';</script>";
                exit();
            } else {
                echo "<p class='text-danger'>Failed to create product.</p>";
            }
        }
        $productController->createProduct($name, $category_id, $warehouse_id, $price, $stock);
        echo "<script>window.location.href='products.php';</script>";
        exit();
    }

    // Handle deletion
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $productController->deleteProduct($id);
        
        echo "<script>window.location.href='products.php';</script>";
        exit();
    }
    ?>

</div>

<?php include '../templates/footer.php'; ?>