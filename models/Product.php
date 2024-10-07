<?php
class Product {
    private $conn;
    private $table = 'products';

    public $id;
    public $name;
    public $category_id;
    public $warehouse_id;
    public $price;
    public $stock;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "
            SELECT 
                products.id, 
                products.name AS product_name, 
                categories.name AS category_name, 
                warehouses.name AS warehouse_name, 
                products.price, 
                products.stock 
            FROM {$this->table} 
            LEFT JOIN categories ON products.category_id = categories.id
            JOIN warehouses ON products.warehouse_id = warehouses.id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT id, name, category_id, warehouse_id, price, stock FROM " . $this->table . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET name=:name, category_id=:category_id, warehouse_id=:warehouse_id, price=:price, stock=:stock";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":warehouse_id", $this->warehouse_id);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":stock", $this->stock);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET name=:name, category_id=:category_id, warehouse_id=:warehouse_id, price=:price, stock=:stock WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":warehouse_id", $this->warehouse_id);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":stock", $this->stock);
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