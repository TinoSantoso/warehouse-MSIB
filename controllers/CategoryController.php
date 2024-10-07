<?php
require_once '../config/database.php';
require_once '../models/Category.php';

class CategoryController {
    private $db;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->category = new Category($this->db);
    }

    public function getAllCategories() {        
        return $this->category->readAll();
    }

    // Create a new category
    public function createCategory($name) {
        $this->category->name = $name;

        if ($this->category->create()) {
            return true;
        }
        return false;
    }

    // Update an existing category (can be expanded if needed)
    public function updateCategory($id, $name) {
        $this->category->id = $id;
        $this->category->name = $name;

        if ($this->category->update()) {
            return true;
        }
        return false;
    }

    // Delete a category
    public function deleteCategory($id) {
        $this->category->id = $id;

        if ($this->category->delete()) {
            return true;
        }
        return false;
    }
}
?>