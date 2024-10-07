<?php include '../templates/header.php'; ?>

<div class="container">

    <?php
        require_once '../controllers/WarehouseController.php';
        $warehouseController = new WarehouseController();

        // Initialize variables for the form
        $name = '';
        $location = '';
        $status = '';
        $opening_hour = '';
        $closing_hour = '';
        $editMode = false;
        $warehouseId = null;

        // Check if editing an existing warehouse
        if (isset($_GET['edit'])) {
            $warehouseId = $_GET['edit'];
            $warehouse = $warehouseController->getWarehouseById($warehouseId);

            if ($warehouse) {
                $name = $warehouse['name'];
                $location = $warehouse['location'];
                $status = $warehouse['status'];
                $opening_hour = $warehouse['opening_hour'];
                $closing_hour = $warehouse['closing_hour'];
                $editMode = true;  // Set to true to indicate we are editing
            }
        }
    ?>

    <!-- Form to Add Warehouse -->
    <form action="warehouses.php" method="POST" class="mb-4 mt-2">
        <input type="hidden" name="id" value="<?php echo $warehouseId; ?>">  <!-- Hidden field for warehouse ID -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Warehouse Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>" required>
                </div>
            </div>
        </div>
        <!-- Opening and Closing Hours Side by Side -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="opening_hour">Opening Hour</label>
                    <input type="time" class="form-control" id="opening_hour" name="opening_hour" value="<?php echo $opening_hour; ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="closing_hour">Closing Hour</label>
                    <input type="time" class="form-control" id="closing_hour" name="closing_hour" value="<?php echo $closing_hour; ?>" required>
                </div>
            </div>
        </div>
        <!-- Status as Radio Buttons -->
        <div class="form-group mt-3">
            <label>Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="active" value="active" <?php echo ($status == 'active') ? 'checked' : ''; ?> required>
                <label class="form-check-label" for="active">Active</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive" <?php echo ($status == 'inactive') ? 'checked' : ''; ?> required>
                <label class="form-check-label" for="inactive">Inactive</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3 w-25">
            <?= $editMode ? 'Update Warehouse' : 'Add Warehouse'; ?>
        </button>
    </form>

    <!-- Warehouse List -->
    <h2>List of Warehouses</h2>

    <?php 
    $warehouses = $warehouseController->getAllWarehouses();

    if ($warehouses->rowCount() > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Opening Hour</th>
                    <th>Closing Hour</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $warehouses->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= ucfirst($row['name']); ?></td>
                        <td><?= ucfirst($row['location']); ?></td>
                        <td>
                            <span class="badge rounded-pill bg-<?= $row['status'] == 'active' ? 'success' : 'danger-subtle'; ?>">
                                <?= ucfirst($row['status']); ?>
                            </span>
                        </td>
                        <td><?= $row['opening_hour']; ?></td>
                        <td><?= $row['closing_hour']; ?></td>
                        <td>
                            <a href="warehouses.php?edit=<?= $row['id']; ?>" class="btn btn-warning btn-sm me-2">Edit</a>
                            <a href="warehouses.php?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this warehouse?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No warehouses available</p>
    <?php endif; ?>

    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $status = $_POST['status'];
        $opening_hour = $_POST['opening_hour'];
        $closing_hour = $_POST['closing_hour'];

        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Update warehouse
            $warehouseId = $_POST['id'];
            if ($warehouseController->updateWarehouse($warehouseId, $name, $location, $status, $opening_hour, $closing_hour)) {
                echo "<script>window.location.href='warehouses.php';</script>";
                exit();
            } else {
                echo "<p class='text-danger'>Failed to update warehouse.</p>";
            }
        } else {
            // Create new warehouse
            if ($warehouseController->createWarehouse($name, $location, $status, $opening_hour, $closing_hour)) {
                echo "<script>window.location.href='warehouses.php';</script>";
                exit();
            } else {
                echo "<p class='text-danger'>Failed to create warehouse.</p>";
            }
        }
    }

    // Handle deletion
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $warehouseController->deleteWarehouse($id);
        echo "<script>window.location.href='warehouses.php';</script>";
        exit();
    }
    ?>

</div>

<?php include '../templates/footer.php'; ?>