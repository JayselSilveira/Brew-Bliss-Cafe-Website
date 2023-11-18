<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brewblisscafe";

$conn = mysqli_connect($servername, $username, $password, $dbname);   

if(!$conn){
    die("Connection to this database failed due to" . mysqli_connect_error());
}

$sql = "SELECT * FROM coffees;";
$result = $conn->query($sql);

$conn->close();
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brewblisscafe";

$conn = mysqli_connect($servername, $username, $password, $dbname);   

if(!$conn){
    die("Connection to this database failed due to" . mysqli_connect_error());
}

$sql2 = "SELECT * FROM coffees;";
$result2 = $conn->query($sql2);

if(isset($_POST['delete'])){
    $temp = $_GET['item_id'];
    // echo '<script type="text/javascript"> ';  
    // echo ' function openulr(newurl) {';  
    // echo '  if (confirm("Are you sure you want to delete this user?")) {';
    $sql3 = "DELETE FROM coffees WHERE item_id = '$temp';";
    if($conn->query($sql3) == true) {
        echo '<script type ="text/JavaScript">';
        echo 'alert("User deleted successfully!")';
        echo '</script>';
        header("location: adminCoffees.php");
    } else {
        echo "ERROR: $sql3 <br> $conn->error";
    }
    echo 'alert("Successfully deleted!")';
}

$conn->close();
?>

<?php
  session_start();
  if(!isset($_SESSION['admin_full_name'])){
    header("location: login.php");
  }
?>

<?php
  if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header("location: login.php");
  }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="item.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Item</title>
</head>

<body style="background-image: url(images/home.jpg); background-size: 1500px 1000px;">
    <?php  
        $temp = $_GET['item_id'];
        while($rows = mysqli_fetch_array($result)){
            if($rows['item_id'] == $temp){
    ?>
    <header>
        <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
        <ul class="navigation">
            <li><form method="post" action="editCoffees.php?item_id=<?php echo $rows['item_id']?>"><a href="editCoffees.php?item_id=<?php echo $rows['item_id']?>"><input type="submit" id="edit" name="edit" value="&#9998;  Edit  " style="font-size: 20px; font-weight: 600; color: #60371E; background: #6ffc8e; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
            <li><form method="post" action="adminItemCoffees.php?item_id=<?php echo $rows['item_id']?>"><a href="adminCoffees.php?item_id=<?php echo $rows['item_id']?>"><input type="submit" id="delete" name="delete" value="&#10006;  Delete " style="font-size: 20px; font-weight: 600; color: #60371E; background: #f51637; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
            <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
        </ul>
      </header>
    

    <section class="item" id="item">
        <div class="content">
            <div class="card" style="height: 100%; background-color: #FFD7A0;">
                <div class="title">
                    <h2 class="title-text" style="text-align:center;">
                        <?php 
                            echo $rows['item_name'];
                        ?>
                    </h2>
                </div>

                <div class="imgBx">
                    <img src="uploadedImages/menu/coffees/<?php echo $rows['item_image'];?>" width="700" height="330" style="object-fit:contain">
                </div>

                <div class="text">
                    <h3 style="margin-left:30px;"><?php echo $rows['item_description'];?></h3><br><hr>
                    <form method="post" action="#">
                        <label style="margin-left:265px;">Price per quantity: <?php echo $rows['item_price'];?></label><br>
                        <label for="quantity" style="margin-left:200px;">Quantity (between 1 and 5):</label>
                        <input type="number" id="quantity" name="quantity" min="1" max="5" required><br>
                        <a>
                            <input type="submit" id="add" name="add" class="btn" value="Add to Cart" style="margin-left:255px; margin-bottom:0;">
                        </a>
                    </form><br><hr>
                    <a href="#" class="btn" style="margin-left:270px;">View Cart</a>
                </div>
            </div>
    </section>
    <?php
       }
    }
    ?>

</body>

</html>