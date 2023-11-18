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

  $total_price1 = $total_price2 = $total_price3 = 0;

    $sql = "SELECT * FROM users u
            JOIN cart c ON u.email_id = c.added_by
            JOIN coffees i ON c.item_id = i.item_id
            WHERE c.item_type = 1;";
    $result = $con->query($sql);
    while($row = mysqli_fetch_array($result,  MYSQLI_ASSOC)){
        $quantity1 = $row['quantity'];
        $unit_price1 = $row['item_price'];
        $total_price1 = $total_price1 + ($unit_price1 * $quantity1);
    }
    
    $sql1 = "SELECT * FROM users u
            JOIN cart c ON u.email_id = c.added_by
            JOIN desserts i ON c.item_id = i.item_id
            WHERE c.item_type = 2;";
    $result1 = $con->query($sql1);
    while($row1 = mysqli_fetch_array($result1,  MYSQLI_ASSOC)){
        $quantity2 = $row1['quantity'];
        $unit_price2 = $row1['item_price'];
        $total_price2 = $total_price2 + ($unit_price2 * $quantity2);
    }
    
    $sql2 = "SELECT * FROM users u
            JOIN cart c ON u.email_id = c.added_by
            JOIN specials i ON c.item_id = i.item_id
            WHERE c.item_type = 3;";
    $result2 = $con->query($sql2);
    while($row2 = mysqli_fetch_array($result2,  MYSQLI_ASSOC)){
        $quantity3 = $row2['quantity'];
        $unit_price3 = $row2['item_price'];
        $total_price3 = $total_price3 + ($unit_price3 * $quantity3);
    }

    $total_price = $total_price1 + $total_price2 + $total_price3;
  
    session_start();
    $added_by = $_SESSION['email_id'];
    $user_id = $_GET['user_id'];

    $sql3 = "SELECT * FROM cart c WHERE '$added_by' = c.added_by;";
    $result3 = $con->query($sql3);
    $row3 = mysqli_fetch_array($result3,  MYSQLI_ASSOC);
    $sql_user_email = $row3['added_by'];

    if(isset($_POST['order'])){
        $sql4 = "INSERT INTO orders(placed_timestamp, placed_by, amount_paid) VALUES(CURRENT_TIMESTAMP(), '$added_by', $total_price)";
        if($con->query($sql4) == true){
            $sql5 = "DELETE FROM cart WHERE added_by = '$added_by'";
            $result5 = $con->query($sql5);
            echo '<script type="text/javascript">
                window.onload = function () { alert("Order Placed."); }
            </script>';
            header("location: cart.php?user_id=$user_id");
        } else {
            echo "ERROR: $sql4 <br> $con->error";
        }
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
      <title>Order Payment</title>
   </head>
   <body style="background: #FFD7A0; background-image: url(images/coffee4.jpg);">
        <header>
            <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
            <ul class="navigation">
                <li><form method="post"><a href="http://localhost/BrewBlissCafe/orders.php?user_id=<?php echo $user_id;?>"><input type="button" id="orders" name="orders" value="My Orders" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
                <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
            </ul>
        </header>
        <section class="cart">
        <div class="title">
            <h2 class="title-text" style="text-shadow: 0 0 3px #FFD7A0, 0 0 5px #60371E;">Order <span>Payment</span></h2>
        </div>

        
    <?php if($sql_user_email == $added_by){ ?>
        <?php 
// Include the qrlib file 
include 'phpqrcode/qrlib.php'; 

$uniqueId = uniqid();

$paymentString = "Order ID: $uniqueId\n";
$paymentString .= "\nOrder Payment of \n";
$paymentString .= "Rs. $total_price to \n";
$paymentString .= "Brew Bliss Cafe,\n";
$paymentString .= "Panjim,\n";
$paymentString .= "Goa.\n";
  
// $path variable store the location where to  
// store image and $file creates directory name 
// of the QR code file by using 'uniqid' 
// uniqid creates unique id based on microtime 
$path = 'images/qrcodes/'; 
$file = $path.$uniqueId.".png"; 
  
// $ecc stores error correction capability('L') 
$ecc = 'L'; 
$pixel_Size = 5; 
$frame_Size = 5; 
  
// Generates QR Code and Stores it in directory given 
QRcode::png($paymentString, $file, $ecc, $pixel_Size, $frame_Size); 
  
// Displaying the stored QR code from directory 
echo "<center><img src='".$file."'></center>"; 
?> 
            <div class="card" style="border:3px solid #FFD7A0; margin:auto; display:inline-block; background-color:#FFD7A0; font-size:15px; margin-top:3%; margin-left:32%; margin-right:3%; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition:0.3s; width:35%; height:12%; text-align:center;">
                <div class="container">
                    <div style="border:1px solid #FFD7A0; text-align:center; font-size:20px;">
                        <h3 style="color: #60371E; font-weight: 500; text-shadow: 0 0 3px #FFD7A0, 0 0 5px #60371E;">Total Amount Payable: Rs. <?php echo $total_price;?></h3>
                    </div>
                </div>
            </div>
            
            <form method="post" action="payment.php?user_id=<?php echo $user_id;?>">
            <a href="cart.php?user_id=<?php echo $user_id;?>">
                <input type="submit" id="order" name="order" class="order" value="Place Order" 
                style="margin-left:41%; 
                margin-bottom:0; 
                font-size: 1.3rem;
                font-weight: 700;
                color: #FFD7A0;
                background: #60371E;
                display: inline-block;
                padding: 10px 30px;
                margin-top: 20px;
                text-transform: uppercase;
                letter-spacing: 2px;
                transition: 0.5s;
                -webkit-transition: 0.5s;
                -moz-transition: 0.5s;
                -ms-transition: 0.5s;
                -o-transition: 0.5s;
                text-decoration: none;">
            </a>
            </form>
      </section>
      
    <?php } else {?>
        <div style="border:1px solid #FFD7A0; text-align:center; font-size:20px; background-color:#FFD7A0;">
            <h3 style="color: #60371E; font-weight: 500; text-shadow: 0 0 3px #FFD7A0, 0 0 5px #60371E;">No items added to Cart.</h3>
        </div>
    <?php } ?>
        
   </body>
</html>