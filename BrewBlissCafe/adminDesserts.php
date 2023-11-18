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
  
  //$temp = $_GET['id'];

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
      <meta charset="utf-8">
      <link rel="stylesheet" href="coffees.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title>Desserts</title>
   </head>
   <body style="background-color: #60371E; background-image: url(images/dessertbg1.jpg); background-size: auto;">
      <header>
        <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
        <ul class="navigation">
            <li><a href="http://localhost/BrewBlissCafe/addDesserts.php"><input type="submit" id="addDesserts" name="addDesserts" value="Add a Dessert +" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></li>
            <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
        </ul>
      </header>
      <section class="coffee">
        <div class="title">
          <h2 class="title-text">Delicious <span>Desserts</span></h2>
          <h3 style="color: #FFD7A0; font-weight: 500; text-shadow: 0 0 3px #FFD7A0, 0 0 5px #60371E;">"Dessert makes everything better."</h3><br>
        </div>
        
        <?php
            while($rows = mysqli_fetch_array($result,  MYSQLI_ASSOC)){
        ?>
            <a href="adminItemDesserts.php?item_id=<?php echo $rows['item_id'];?>" style="text-decoration: none";><div class="card" style="border:3px solid #FFD7A0; display:inline-block; color:#000; background-color:#FFD7A0; font-size:15px; margin-top:5%; margin-bottom:2%; margin-left:4%; margin-right:3%; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition:0.3s; width:25%; height:37%; text-align:center;">
            <div class="container" style="margin-bottom:5%; margin-top:13%;">
                    <div style="border:1px solid #FFD7A0; text-align:center; font-size:20px;">
                        <img src="uploadedImages/menu/desserts/<?php echo $rows['item_image'];?>" width="300" height="200" style="object-fit:contain;">
                        <h3 style="color: #60371E; font-weight: 500; text-shadow: 0 0 3px #FFD7A0, 0 0 5px #60371E;"><?php echo $rows['item_name'];?></h3>
                    </div>
                </div>
            </div></a>
          <?php
            }
            ?>
      </section>
   </body>
</html>