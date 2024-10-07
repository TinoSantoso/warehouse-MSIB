<?php
require_once '../config/database.php';
require_once '../models/Product.php';

class ProductController {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }

    public function getAllProducts() {
        return $this->product->readAll();
    }

    public function getProductById($id) {
        $this->product->id = $id;
        return $this->product->readOne();
    }

    public function createProduct($name, $category_id, $warehouse_id, $price, $stock) {
        $this->product->name = $name;
        $this->product->category_id = $category_id;
        $this->product->warehouse_id = $warehouse_id;
        $this->product->price = $price;
        $this->product->stock = $stock;

        if ($this->product->create()) {
            return true;
        }
        return false;
    }

    public function updateProduct($id, $name, $category_id, $warehouse_id, $price, $stock) {
        $this->product->id = $id;
        $this->product->name = $name;
        $this->product->category_id = $category_id;
        $this->product->warehouse_id = $warehouse_id;
        $this->product->price = $price;
        $this->product->stock = $stock;

        if ($this->product->update()) {
            return true;
        }
        return false;
    }

    public function deleteProduct($id) {
        $this->product->id = $id;
        return $this->product->delete();
    }
}
?>