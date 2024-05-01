<?php

class ProductManagement {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM product";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function updateProduct($id, $name, $category, $quantity, $price) {
        $updateSql = "UPDATE product SET name=?, catagory=?, quantity=?, price=? WHERE id=?";
        $stmt = $this->conn->prepare($updateSql);
        $stmt->bind_param("ssdii", $name, $category, $quantity, $price, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function removeProduct($id) {
        $deleteSql = "DELETE FROM product WHERE id=?";
        $stmt = $this->conn->prepare($deleteSql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

?>
