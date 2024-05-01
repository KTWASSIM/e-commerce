<?php
session_start();

include 'header.php';
include 'lib/connection.php';
include 'ProductManagement.php';

$productManagement = new ProductManagement($conn);

if(isset($_SESSION['auth']) && $_SESSION['auth'] != 1) {
    header("location:login.php");
    exit; 
} elseif (!isset($_SESSION['auth'])) {
    header("location:login.php");
    exit; 
}

if(isset($_POST['update_update_btn'])) {
    $id = $_POST['update_id'];
    $name = $_POST['update_name'];
    $category = $_POST['update_catagory'];
    $quantity = $_POST['update_quantity'];
    $price = $_POST['update_Price'];

    if($productManagement->updateProduct($id, $name, $category, $quantity, $price)) {
        header('location:all_product.php');
    }
}

if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if($productManagement->removeProduct($id)) {
        header('location:all_product.php');
    }
}

$result = $productManagement->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <link rel="stylesheet" href="css/pending_orders.css">
</head>
<body>

<div class="container pendingbody">
    <h5>All Product</h5>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><img src="product_img/<?php echo $row['imgname']; ?>" style="width:50px;"></td>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="hidden" name="update_id" value="<?php echo $row['id']; ?>" >
                            <td><input type="text" name="update_name" value="<?php echo $row['name']; ?>" ></td>
                            <td><input type="text" name="update_catagory" value="<?php echo $row['catagory']; ?>" ></td>
                            <td><input type="number" name="update_quantity" value="<?php echo $row['quantity']; ?>" ></td>
                            <td><input type="number" name="update_Price" value="<?php echo $row['Price']; ?>" ></td>
                            <td><input type="submit" value="update" name="update_update_btn"></td>
                        </form>
                        <td><a href="all_product.php?remove=<?php echo $row['id']; ?>">remove</a></td>
                    </tr>
                    <?php 
                }
            } else {
                echo "0 results";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
