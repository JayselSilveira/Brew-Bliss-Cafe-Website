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

    $sql = "SELECT * FROM users u
            JOIN cart c ON u.email_id = c.added_by
            JOIN coffees i ON c.item_id = i.item_id
            WHERE c.item_type = 1;";
    $result = $con->query($sql);

    $sql1 = "SELECT * FROM users u
            JOIN cart c ON u.email_id = c.added_by
            JOIN desserts i ON c.item_id = i.item_id
            WHERE c.item_type = 2;";
    $result1 = $con->query($sql1);

    $sql2 = "SELECT * FROM users u
            JOIN cart c ON u.email_id = c.added_by
            JOIN specials i ON c.item_id = i.item_id
            WHERE c.item_type = 3;";
    $result2 = $con->query($sql2);
  
    session_start();
    $added_by = $_SESSION['email_id'];
    $user_id = $_GET['user_id'];

    $total_items = 0;
    $to_pay = 0;

  if(isset($_POST['deleteCoffee'])){
    $item_id = $_GET['item_id'];
    $sql1 = "DELETE FROM cart WHERE added_by = '$added_by' AND item_type = 1 AND item_id = '$item_id';";
    if($con->query($sql1) == true) {
        echo '<script type ="text/JavaScript">';
        echo 'alert("Item removed from cart!")';
        echo '</script>';
    } else {
      echo "ERROR: $sql1 <br> $con->error";
    }
    echo 'alert("Successfully deleted!")'; 
  }

  if(isset($_POST['deleteDessert'])){
    $item_id = $_GET['item_id'];
    $sql2 = "DELETE FROM cart WHERE added_by = '$added_by' AND item_type = 2 AND item_id = '$item_id';";
    if($con->query($sql2) == true) {
        echo '<script type ="text/JavaScript">';
        echo 'alert("Item removed from cart!")';
        echo '</script>';
    } else {
      echo "ERROR: $sql2 <br> $con->error";
    }
    echo 'alert("Successfully deleted!")'; 
  }


  if(isset($_POST['deleteSpecial'])){
    $item_id = $_GET['item_id'];
    $sql3 = "DELETE FROM cart WHERE added_by = '$added_by' AND item_type = 3 AND item_id = '$item_id';";
    if($con->query($sql3) == true) {
        echo '<script type ="text/JavaScript">';
        echo 'alert("Item removed from cart!")';
        echo '</script>';
    } else {
      echo "ERROR: $sql3 <br> $con->error";
    }
    echo 'alert("Successfully deleted!")'; 
  }


  // Close the database connection
  $con->close();
?>

<?php
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
      <link rel="stylesheet" href="manageUsers.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title>Cart</title>
   </head>
   <body style="background: #FFD7A0; background-image: url(images/coffee3.jpg); background-size: 300px 300px;">
        <header>
            <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
            <ul class="navigation">
                <li><form action="payment.php?user_id=<?php echo $user_id?>" method="post"><a href="payment.php?user_id=<?php echo $user_id?>"><input type="submit" id="buy" name="buy" value="Buy Now &#128722;" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
                <li><form method="post"><a href="http://localhost/BrewBlissCafe/orders.php?user_id=<?php echo $user_id;?>"><input type="button" id="orders" name="orders" value="My Orders" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
                <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
            </ul>
        </header>
      <section class="cart">
        <div class="title">
            <h2 class="title-text" style="text-shadow: 0 0 3px #FFD7A0, 0 0 5px #60371E;">My <span>Cart</span></h2>
        </div>
        
        <table style="border:5px solid #60371E; width:100%;" bgcolor="#FFD7A0">
          <tr style="outline:3px solid #60371E; color:#60371E; font-size:25px;">
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;">Image</th>
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;">Item Name</th>
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;">Quantity</th>
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;">Unit Price</th>
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;">Total Price</th>
            <th style="outline:3px solid #60371E; text-align:center; color:#60371E;"> </th>
          </tr>

          <?php
            while($rows = mysqli_fetch_array($result)){
              if($rows['added_by']==$_SESSION["email_id"]){
                $cart_id = $rows['cart_id'];
                $added_by = $rows['added_by'];
                $quantity = $rows['quantity'];
                $unit_price = $rows['item_price'];
                $total_price = $unit_price * $quantity;
                $total_items = $total_items + $quantity;
                $to_pay = $to_pay + $total_price;
          ?>

          <tr style="color:white;">
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><img src="uploadedImages/menu/coffees/<?php echo $rows['item_image'];?>" style="object-fit:contain;" width="300" height="200"></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><?php echo $rows['item_name'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><?php echo $rows['quantity'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">Rs. <?php echo $rows['item_price'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">Rs. <?php echo $total_price;?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">

            <?php
            if($_SESSION["full_name"] == $rows['full_name'] && $_SESSION["email_id"] == $rows['added_by']) { ?>
              <form action="cart.php?user_id=<?php echo $rows['user_id']?>&item_id=<?php echo $rows['item_id']?>" method="post"><a href="cart.php?user_id=<?php echo $rows['user_id']?>&item_id=<?php echo $rows['item_id']?>"><input type="submit" id="<?php echo $rows['post_id'];?>" value="Remove Item" name="deleteCoffee" class="btn" style="background-color:#f51637; font-weight:500; font-size: 1.2rem; 
              color: #fff; display: inline-block; padding: 2px 18px; margin-top: 10px; text-transform: uppercase; letter-spacing: 2px; text-decoration: none; width: 190px;"></a></form></td></tr>
          
            <?php
                    }
                }
            }
          ?>


        <?php
            while($rows1 = mysqli_fetch_array($result1)){
              if($rows1['added_by']==$_SESSION["email_id"]){
                $cart_id = $rows1['cart_id'];
                $added_by = $rows1['added_by'];
                $quantity = $rows1['quantity'];
                $unit_price = $rows1['item_price'];
                $total_price = $unit_price * $quantity;
                $total_items = $total_items + $quantity;
                $to_pay = $to_pay + $total_price;
          ?>

          <tr style="color:white;">
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><img src="uploadedImages/menu/desserts/<?php echo $rows1['item_image'];?>" style="object-fit:contain;" width="300" height="200"></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><?php echo $rows1['item_name'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><?php echo $rows1['quantity'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">Rs. <?php echo $rows1['item_price'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">Rs. <?php echo $total_price;?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">

            <?php
            if($_SESSION["full_name"] == $rows1['full_name'] && $_SESSION["email_id"] == $rows1['added_by']) { ?>
              <form action="cart.php?user_id=<?php echo $rows1['user_id']?>&item_id=<?php echo $rows1['item_id']?>" method="post"><a href="cart.php?user_id=<?php echo $rows1['user_id']?>&item_id=<?php echo $rows1['item_id']?>"><input type="submit" id="<?php echo $rows['post_id'];?>" value="Remove Item" name="deleteDessert" class="btn" style="background-color:#f51637; font-weight:500; font-size: 1.2rem; 
              color: #fff; display: inline-block; padding: 2px 18px; margin-top: 10px; text-transform: uppercase; letter-spacing: 2px; text-decoration: none; width: 190px;"></a></form></td></tr>
          
            <?php
                    }
                }
            }
          ?>


        <?php
            while($rows2 = mysqli_fetch_array($result2)){
              if($rows2['added_by']==$_SESSION["email_id"]){
                $cart_id = $rows2['cart_id'];
                $added_by = $rows2['added_by'];
                $quantity = $rows2['quantity'];
                $unit_price = $rows2['item_price'];
                $total_price = $unit_price * $quantity;
                $total_items = $total_items + $quantity;
                $to_pay = $to_pay + $total_price;
          ?>

          <tr style="color:white;">
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><img src="uploadedImages/menu/specials/<?php echo $rows2['item_image'];?>" style="object-fit:contain;" width="300" height="200"></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><?php echo $rows2['item_name'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;"><?php echo $rows2['quantity'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">Rs. <?php echo $rows2['item_price'];?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">Rs. <?php echo $total_price;?></td>
            <td style="outline:3px solid #60371E; text-align:center; color:#60371E;">

            <?php
            if($_SESSION["full_name"] == $rows2['full_name'] && $_SESSION["email_id"] == $rows2['added_by']) { ?>
              <form action="cart.php?user_id=<?php echo $rows2['user_id']?>&item_id=<?php echo $rows2['item_id']?>" method="post"><a href="cart.php?user_id=<?php echo $rows2['user_id']?>&item_id=<?php echo $rows2['item_id']?>"><input type="submit" id="<?php echo $rows['post_id'];?>" value="Remove Item" name="deleteDessert" class="btn" style="background-color:#f51637; font-weight:500; font-size: 1.2rem; 
              color: #fff; display: inline-block; padding: 2px 18px; margin-top: 10px; text-transform: uppercase; letter-spacing: 2px; text-decoration: none; width: 190px;"></a></form></td></tr>
          
            <?php
                    }
                }
            }
          ?>
        </table>
        

        <div style="background: #FFD7A0;">
            <h2 class="title-text" style="text-shadow: 0 0 3px #FFD7A0, 0 0 5px #60371E; text-align: right; color: #60371E;">Total Items: <?php echo $total_items?><br>Total Price: Rs. <?php echo $to_pay?></h2>
        </div>
      </section>
   </body>
</html>