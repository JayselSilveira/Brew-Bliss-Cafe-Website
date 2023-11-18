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

    $sql1 = "SELECT * FROM popular_cafe_offerings WHERE offering_id = 1;";
    $result1 = $con->query($sql1);
    $row1 = mysqli_fetch_array($result1,  MYSQLI_ASSOC);
    $value1 = $row1['item_id'];

    $sql2 = "SELECT * FROM popular_cafe_offerings WHERE offering_id = 2;";
    $result2 = $con->query($sql2);
    $row2 = mysqli_fetch_array($result2,  MYSQLI_ASSOC);
    $value2 = $row2['item_id'];

    $sql3 = "SELECT * FROM coffees WHERE item_id = $value1";
    $result3 = $con->query($sql3);
    $row3 = mysqli_fetch_array($result3,  MYSQLI_ASSOC);

    $sql4 = "SELECT * FROM desserts WHERE item_id = $value2";
    $result4 = $con->query($sql4);
    $row4 = mysqli_fetch_array($result4,  MYSQLI_ASSOC);

    // Close the database connection
    $con->close();
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
    <meta charset="UTF-8">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Brew Bliss Café</title>
  </head>

  <body>
    <header>
      <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
      <ul class="navigation">
        <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
      </ul>
    </header>

    <section class="menu" id="menu" style="background: #FFD7A0; background-image: url(images/footer_image.jpg)">
      <div class="title">
        <h2 class="title-text">Popular <span>Café</span> offerings</h2>
      </div>
      <div class="content">
        
          <div class="card" style="background: #FFD7A0;">
            <div class="imgBx">
            <a href="http://localhost/BrewBlissCafe/adminItemCoffees.php?item_id=<?php echo $row3['item_id'];?>" class="card-links">
              <img src="./uploadedImages/menu/coffees/<?php echo $row3['item_image'];?>" alt="Popular Coffee Image" style="object-fit:contain;">
            </a>
            </div>
            <div class="text">
              <h3><?php echo $row3['item_name'];?></h3>
            </div>
            <p style="text-align: center;"><a href="editPopularCafeOffering1.php?item_id=<?php echo $row3['item_id'];?>" class="btn">Update</a></p></a>
          </div>       
         
        <div class="card" style="background: #FFD7A0;">
            <!--<a href="http://localhost/BrewBlissCafe/item.php?item_id=<?php echo $rows['item_id'];?>" class="card-links"></a>-->
            <div class="imgBx">
            <a href="http://localhost/BrewBlissCafe/adminitemDesserts.php?item_id=<?php echo $row4['item_id'];?>" class="card-links">
                <img src="./uploadedImages/menu/desserts/<?php echo $row4['item_image'];?>" alt="Popular Dessert Image" style="object-fit:contain;">
            </a>
            </div>
            <div class="text">
                <h3><?php echo $row4['item_name'];?></h3>
            </div>
            <p style="text-align: center; margin-bottom:10px;"><a href="editPopularCafeOffering2.php?item_id=<?php echo $row4['item_id'];?>" class="btn">Update</a></p>
        </div>
      </div>
    </section>
  </body>
</html>