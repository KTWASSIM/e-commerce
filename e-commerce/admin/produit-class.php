<?php

class produit {
    private $conn;
    private $name;
    private $catagory; 
    private $description;
    private $quantity;
    private $price;
    private $filename;

    public function __construct($db, $name, $catagory, $description, $quantity, $price, $filename) {
        $this->conn = $db;
        $this->name = $name;
        $this->catagory = $catagory; 
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->filename = $filename;
    }
    
    public function add_product() {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] != 1) {
            header("location:login.php");
            exit; 
        } elseif (!isset($_SESSION['auth'])) {
            header("location:login.php");
            exit; 
        }
        
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $catagory = $_POST['catagory']; 
            $description = $_POST['description'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $filename = $_FILES["uploadfile"]["name"];
            
            if (empty($name)) {
                die("Name cannot be empty");
            }
            
            $insertSql = "INSERT INTO product(name, catagory, description, quantity, price, imgname) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($insertSql);
            
            $stmt->bind_param("ssssss", $name, $catagory, $description, $quantity, $price, $filename);
            
            if ($stmt->execute()) {
                $tempname = $_FILES["uploadfile"]["tmp_name"];
                $folder = "product_img/".$filename;
                move_uploaded_file($tempname, $folder);
            } else {
                die($stmt->error); 
            }
            
            $stmt->close();
        }
    }
    public function getAllProducts() {
        $sql = "SELECT * FROM product";
        $result = $this->conn->query($sql);
        return $result;
    }
} 
?>
