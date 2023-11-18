<?php
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

  $sql = "SELECT * FROM desserts;";
  $result = $con->query($sql);

  if(isset($_POST['update'])){
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

    $temp1 = $_GET['item_id'];

    if(isset($_FILES['item_image'])){
        //move_uploaded_file($_FILES["image"]["tmp_name"],"uploadedImages/" . $_FILES["image"]["name"]);			
        //$image=$_FILES["image"]["name"];
        $sql1 = "UPDATE desserts SET item_name = '$item_name', item_description = '$item_description', item_price = '$item_price', item_image = '$item_image' WHERE item_id = '$temp1';";
    } else {
        $sql1 = "UPDATE desserts SET item_name = '$item_name', item_description = '$item_description', item_price = '$item_price' WHERE item_id = '$temp1';";
    }
    
    //mysqli_query($con, $sql1);
    //$result1 = $con->query($sql1);
    if($con->query($sql1) == true){
        header("location: adminDesserts.php");
     } else {
        echo "ERROR: $sql1 <br> $con->error";
     }
    //alert("Successfully updated!");

    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder))  {
        $msg = "Image uploaded successfully";
    }else{
        $msg = "Failed to upload image";
    }
  }

  // Close the database connection
  $con->close();
?>

<?php
  session_start();
  if(!isset($_SESSION['admin_full_name'])){
    header("location: login.php");
  }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="edit.css">
    <title>Edit Page</title>
</head>

<body background="./images/tart.jpg">
    <div class="card" style="height: 110%; margin-top:10%;">
        <div>
            <h4><a href="http://localhost/BrewBlissCafe/adminDesserts.php" style="color:#60371E; margin-left:190px;">Delicious Desserts</a></h4><hr style="margin-bottom:10px;">
            <h2>Edit Page</h2>
        </div>
        <hr style="margin-bottom:10px;">
        <?php   // LOOP TILL END OF DATA 
            //while($rows=$result->fetch_assoc() &&
            $temp = $_GET['item_id'];
            while($rows = mysqli_fetch_array($result)){
               if($rows['item_id'] == $temp){
          ?>
        <div class="form"></div>
        <form action="editDesserts.php?item_id=<?php echo $rows['item_id']?>" method="post" class="edit" enctype="multipart/form-data">
            <div class="field">
                <p>Dessert Name: 
                    <input type="text" value="<?php echo $rows['item_name'];?>" name="item_name" required>
                </p>
            </div>
            <div class="field">
                <p>Description: 
                    <textarea name="item_description" rows="3" cols="40" required><?php echo $rows['item_description'];?></textarea>
                </p>
            </div>
            <div class="field">
                <p>Price: 
                    <input type="text" value="<?php echo $rows['item_price'];?>" name="item_price" required>
                </p>
            </div>
            <div class="field">
                <p>Image: 
                    <input type="file" name="item_image" id="item_image">
                    <h4>Current Image: <input type="image" src="uploadedImages/menu/desserts/<?php echo $rows['item_image'];?>" alt="Uploaded Image" name="currentImage" width=150 height=120></h4>
                </p>
            </div>
            <div class="btn">
                <input type="submit" value="Save Changes" name="update">
            </div>
        </form>
    </div>
    <?php
}
}
?>
</body>

</html>