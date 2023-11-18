<?php
$insert = false;
$msg = "";

// Set connection variables
$server = "localhost";
$username = "root";
$password = "";
$dbname = "brewblisscafe";

// Create a database connection
$con = mysqli_connect($server, $username, $password, $dbname);

// Check for connection success
if(!$con){
    die("Connection to this database failed due to" . mysqli_connect_error());
}

session_start();
if(isset($_POST['submit'])){
    $item_name = $_POST['item_name'];
    $item_name = trim($item_name);
    $item_name = stripcslashes($item_name);
    $item_name = htmlspecialchars($item_name);

    $item_description = $_POST['item_description'];
    $item_description = trim($item_description);
    $item_description = stripcslashes($item_description);
    $item_description = htmlspecialchars($item_description);

    $item_price = $_POST['item_price'];
    $item_price = trim($item_price);
    $item_price = stripcslashes($item_price);
    $item_price = htmlspecialchars($item_price);

    $item_image = $_FILES["item_image"]["name"];
    $tempname = $_FILES["item_image"]["tmp_name"];    
    $folder = "uploadedImages/menu/desserts/".$item_image;

    $sql = "INSERT INTO desserts(item_name, item_description, item_price, item_image) VALUES('$item_name', '$item_description', '$item_price', '$item_image');";
        
    // Execute query
    if($con->query($sql) == true){
        // Flag for successful insertion
        $insert = true;
        echo '<script type="text/javascript">
         window.onload = function () { alert("Dessert added!"); }
        </script>';  
        header("location: adminDesserts.php");
     } else {
        echo "ERROR: $sql <br> $con->error";
     }
          
    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder))  {
        $msg = "Image uploaded successfully";
    }else{
        $msg = "Failed to upload image";
    }

    // Close the database connection
    $con->close();    
}
?>

<?php
  if(!isset($_SESSION['admin_full_name'])){
    header("location: login.php");
  }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="add.css">
    <title>Add a Dessert</title>
</head>

<body background="./images/donuts2.jpg">
    <div class="card">
        <div>
            <h2>Add a Dessert</h2>
        </div>
        <hr>
        <div class="form"></div>
        <form action="addDesserts.php" method="post" class="addMenu" enctype="multipart/form-data">
            <div class="field">
                <p>Dessert Name: 
                    <input type="text" placeholder="Add a Dessert Name" name="item_name" required>
                </p>
            </div>
            <div class="field">
                <p>Description: 
                    <textarea placeholder="Add a Description" name="item_description" rows="3" cols="40" required></textarea>
                </p>
            </div>
            <div class="field">
                <p>Price: 
                    <input type="text" placeholder="Add the price per quantity" name="item_price" required>
                </p>
            </div>
            <div class="field">
                <p>Image: 
                    <input type="file" name="item_image" id="item_image" required>
                </p>
            </div>
            <div class="btn">
                <input type="submit" value="Add Dessert" name="submit">
            </div>
        </form>
    </div>
</body>

</html>