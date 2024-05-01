<?php

class User {
    private $conn;
    private $f_name;
    private $l_name;
    private $email;
    private $pass;

    public function __construct($db, $f_name, $l_name, $email, $pass) {
        $this->conn = $db;
        $this->f_name = $f_name;
        $this->l_name = $l_name;
        $this->email = $email;
        $this->pass = $pass;
    }

    public function createUser() {
        $query = "INSERT INTO users (f_name, l_name, email, pass) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $this->f_name, $this->l_name, $this->email, $this->pass);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

?>
