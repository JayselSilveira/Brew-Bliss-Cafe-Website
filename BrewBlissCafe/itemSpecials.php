<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brewblisscafe";

$conn = mysqli_connect($servername, $username, $password, $dbname);   

if(!$conn){
    die("Connection to this database failed due to" . mysqli_connect_error());
}

$sql = "SELECT * FROM specials;";
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

session_start();
$added_by = $_SESSION['email_id'];
$item_id = $_GET['item_id'];

$sql2 = "SELECT user_id FROM users WHERE email_id = '$added_by'";
$result2 = $conn->query($sql2);
$row2 = mysqli_fetch_array($result2,  MYSQLI_ASSOC);

if(isset($_POST['add'])){
    $quantity = $_POST['quantity'];
 
    if(isset($_POST['add'])){
        $sql1 = "INSERT INTO cart(added_by, item_type, item_id, quantity) VALUES('$added_by', 3, '$item_id', '$quantity');";
        
        if($conn->query($sql1) == true){
            //header("location: food.php");
            echo '<script type="text/javascript">
                window.onload = function () { alert("Item added to cart."); }
            </script>';
        } else {
            echo "ERROR: $sql1 <br> $conn->error";
        }
    }
}

$conn->close();
?>

<?php
  session_start();
  if(!isset($_SESSION['full_name'])){
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
    <header>
        <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
        <ul class="navigation">
            <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
        </ul>
      </header>
    <?php  
        $temp = $_GET['item_id'];
        while($rows = mysqli_fetch_array($result)){
            if($rows['item_id'] == $temp){
    ?>

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
                    <img src="uploadedImages/menu/specials/<?php echo $rows['item_image'];?>" width="700" height="330" style="object-fit:contain;">
                </div>

                <div class="text">
                    <h3 style="margin-left:30px;"><?php echo $rows['item_description'];?></h3><br><hr>
                    <form method="post" action="itemSpecials.php?item_id=<?php echo $rows['item_id'];?>">
                        <label style="margin-left:265px;">Price per quantity: Rs. <?php echo $rows['item_price'];?></label><br>
                        <label for="quantity" style="margin-left:200px;">Quantity (between 1 and 5):</label>
                        <input type="number" id="quantity" name="quantity" min="1" max="5" required><br>
                        <a>
                            <input type="submit" id="add" name="add" class="btn" value="Add to Cart" style="margin-left:255px; margin-bottom:0;">
                        </a>
                    </form><br><hr>
                    <a href="http://localhost/BrewBlissCafe/cart.php?user_id=<?php echo $row2['user_id'];?>" class="btn" style="margin-left:270px;">View Cart</a>
                </div>
            </div>
    </section>
    <?php
       }
    }
    ?>

</body>

</html>