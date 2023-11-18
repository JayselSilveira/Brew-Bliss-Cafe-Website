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
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Brew Bliss Café</title>
  </head>

  <body>
    <header>
      <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
      <ul class="navigation">
        <li><a href="http://localhost/BrewBlissCafe/popularCafeOfferings.php"><input type="submit" id="popularCafeOfferings" name="popularCafeOfferings" value="Popular Cafe Offerings" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;"></a></li>
        <li><a href="http://localhost/BrewBlissCafe/adminViewOrders.php"><input type="submit" id="viewOrders" name="viewOrders" value="View Orders" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;"></a></li>
        <li><a href="http://localhost/BrewBlissCafe/manageUsers.php"><input type="submit" id="manageUsers" name="manageUsers" value="Manage Users" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;"></a></li>
        <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;"></a></form></li>
      </ul>
    </header>

    <section class="menu" id="menu" style="background: #FFD7A0; background-image: url(images/dessertbg.jpg)">
      <div class="title">
        <h2 class="title-text" style="padding-left: 15px; color: #FFD7A0; font-weight: 700; font-size: 4.5em; text-shadow: 0 0 3px #60371E;"><span>Menu</span></h2>
      </div>
      <div class="content">
        
          <div class="card">
            <a href="http://localhost/BrewBlissCafe/adminCoffees.php" class="card-links">
            <div class="imgBx">
              <img src="./images/coffee.jpg" alt="">
            </div>
            <div class="text">
              <h3>Coffees</h3>
            </div></a>
          </div>       
         
        <div class="card">
          <a href="http://localhost/BrewBlissCafe/adminDesserts.php" class="card-links"></a>
        </a>
          <div class="imgBx">
            <img src="./images/desserts.jpg" alt="">
          </div>
          <div class="text">
            <h3>Desserts</h3>
          </div>
        </div>

        <div class="card">
          <a href="http://localhost/BrewBlissCafe/adminSpecials.php" class="card-links"></a>
        </a>
          <div class="imgBx">
            <img src="./images/special1.jpg" alt="">
          </div>
          <div class="text">
            <h3>Weekly Specials</h3>
          </div>
        </div>
      </div>
    </section>

  </body>
</html>
