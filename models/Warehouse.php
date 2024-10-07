<?php
class Warehouse {
    private $conn;
    private $table = 'warehouses';

    public $id;
    public $name;
    public $location;
    public $status;  // e.g., 'active' or 'inactive'
    public $opening_hour;  // Store the opening time
    public $closing_hour;  // Store the closing time

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT id, name, location, status, opening_hour, closing_hour FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT id, name, location, status, opening_hour, closing_hour FROM " . $this->table . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, location=:location, status=:status, opening_hour=:opening_hour, closing_hour=:closing_hour";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":opening_hour", $this->opening_hour);
        $stmt->bindParam(":closing_hour", $this->closing_hour);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET name=:name, location=:location, status=:status, opening_hour=:opening_hour, closing_hour=:closing_hour WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":opening_hour", $this->opening_hour);
        $stmt->bindParam(":closing_hour", $this->closing_hour);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>