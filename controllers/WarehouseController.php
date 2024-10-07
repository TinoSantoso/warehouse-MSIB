<?php
require_once '../config/database.php';
require_once '../models/Warehouse.php';

class WarehouseController {
    private $db;
    private $warehouse;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->warehouse = new Warehouse($this->db);
    }

    public function getAllWarehouses() {
        return $this->warehouse->readAll();
    }

    public function getWarehouseById($id) {
        $this->warehouse->id = $id;
        return $this->warehouse->readOne();
    }

    // Create a new warehouse
    public function createWarehouse($name, $location, $status, $opening_hour, $closing_hour) {
        $this->warehouse->name = $name;
        $this->warehouse->location = $location;
        $this->warehouse->status = $status;
        $this->warehouse->opening_hour = $opening_hour;
        $this->warehouse->closing_hour = $closing_hour;

        if ($this->warehouse->create()) {
            return true;
        }
        return false;
    }

    // Update an existing warehouse (can be expanded if needed)
    public function updateWarehouse($id, $name, $location, $status, $opening_hour, $closing_hour) {
        $this->warehouse->id = $id;
        $this->warehouse->name = $name;
        $this->warehouse->location = $location;
        $this->warehouse->status = $status;
        $this->warehouse->opening_hour = $opening_hour;
        $this->warehouse->closing_hour = $closing_hour;

        if ($this->warehouse->update()) {
            return true;
        }
        return false;
    }

    // Delete a warehouse
    public function deleteWarehouse($id) {
        $this->warehouse->id = $id;

        if ($this->warehouse->delete()) {
            return true;
        }
        return false;
    }
}
?>