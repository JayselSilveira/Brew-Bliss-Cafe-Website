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

    $sql = "SELECT * FROM orders;";
    $result = $con->query($sql);

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
      <link rel="stylesheet" href="manageUsers.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title>View Orders</title>
   </head>
   <body style="background: #FFD7A0; background-image: url(images/coffee5.jpg); background-size: 300px 300px;">
        <header>
            <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
            <ul class="navigation">
                <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
            </ul>
        </header>
      <section class="cart">
        <div class="title">
            <h2 class="title-text" style="text-shadow: 0 0 3px #FFD7A0, 0 0 5px #60371E;">View <span>Orders</span></h2>
        </div>
        
        <table style="border:5px solid #60371E; width:100%;" bgcolor="#FFD7A0">
          <tr style="outline:3px solid #60371E; color:#60371E; font-size:25px;">
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;">Timestamp</th>
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;">Placed By</th>
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;">Amount Paid</th>
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;"> </th>
          </tr>

          <?php
            while($rows = mysqli_fetch_array($result)){
          ?>

          <tr style="color:white;">
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><?php echo $rows['placed_timestamp'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><?php echo $rows['placed_by'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">Rs. <?php echo $rows['amount_paid'];?></td>
          </tr>
          
            <?php
            }
          ?>
        </table>
      </section>
   </body>
</html>