<?php include '../templates/header.php'; ?>

<div class="container mt-5">
    <div class="jumbotron text-center bg-dark-subtle p-5 rounded">
        <h1 class="display-4">Welcome to the <strong>Warehouse MSIB</strong></h1>
        <p class="lead">Manage your warehouse efficiently. Easily manage categories, products, and warehouses in one place.</p>
        <hr class="my-4">
        <p>Navigate through the system features:</p>
    </div>

    <div class="row mt-4 text-center">
        <!-- Category Feature -->
        <div class="col-md-4">
            <div class="card bg-warning-subtle border-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Category Management</h5>
                    <p class="card-text">Create, update, and manage categories for your products.</p>
                    <a href="../views/categories.php" class="btn btn-primary">Go to Categories</a>
                </div>
            </div>
        </div>

        <!-- Product Feature -->
        <div class="col-md-4">
            <div class="card bg-warning-subtle border-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Product Management</h5>
                    <p class="card-text">Manage your products, including pricing, stock, and categories.</p>
                    <a href="../views/products.php" class="btn btn-primary">Go to Products</a>
                </div>
            </div>
        </div>

        <!-- Warehouse Feature -->
        <div class="col-md-4">
            <div class="card bg-warning-subtle border-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Warehouse Management</h5>
                    <p class="card-text">Manage warehouse locations, opening hours, and product storage.</p>
                    <a href="../views/warehouses.php" class="btn btn-primary">Go to Warehouses</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>