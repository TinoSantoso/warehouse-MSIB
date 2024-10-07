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

    public function uploadProductImages($product_id, $files) {
        $upload_dir = 'uploads/product-images/';
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        foreach ($files['name'] as $key => $name) {
            $file_tmp = $files['tmp_name'][$key];
            $file_ext = pathinfo($name, PATHINFO_EXTENSION);

            // Validate file type
            if (in_array(strtolower($file_ext), $allowed_extensions)) {
                $new_filename = uniqid() . '.' . $file_ext;
                $destination = $upload_dir . $new_filename;

                // Move file to the upload directory
                if (move_uploaded_file($file_tmp, $destination)) {
                    // Insert image details into the database
                    $query = "INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :image_path)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':image_path', $destination);
                    $stmt->execute();
                }
            }
        }
    }
}
?>