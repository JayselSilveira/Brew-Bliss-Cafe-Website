<?php
  $toSearch = false;
  $toSort = false;

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

  $sql1 = "SELECT * FROM users";
  $result1 = $con->query($sql1);

  if(isset($_POST['delete'])){
    $temp = $_GET['user_id'];
    echo '<script type="text/javascript"> ';  
      $sql3 = "DELETE FROM users WHERE user_id = '$temp';";
      if(($con->query($sql3) == true)) {
        echo '<script type ="text/JavaScript">';
        echo 'alert("User deleted successfully!")';
        echo '</script>';
        header("location: manageUsers.php");
      } else {
        echo "ERROR: $sql3 <br> $con->error";
      }
      echo 'alert("Successfully deleted!")';
    echo '</script>';   
  }

  if(isset($_POST['search'])){
      $search = $_POST['searchText'];
      $sql4 = "SELECT * FROM users WHERE full_name like '%$search%';";
      $result4 = mysqli_query($con, $sql4);
      $count4 = mysqli_num_rows($result4);
      
      // If result matched $email_id and $password, table row must be 1 row
      if($count4 != 0) {
        $toSearch = true;
      } else {
        $error = "No user with the entered username exists!";
        echo '<script type="text/javascript">
        window.onload = function () { alert("No user with the entered username exists!"); }
        </script>';        
      }
  }

  if(isset($_POST['sort'])){
    $toSort = true;
    $sort = $_POST['sortText'];
    if($sort === 'Name'){
      $sql5 = "SELECT * FROM users ORDER BY full_name;";
    }
    if($sort === 'Email_ID'){
      $sql5 = "SELECT * FROM users ORDER BY email_id;";
    }
    $result5 = mysqli_query($con, $sql5);
  }

  // Close the database connection
  $con->close();
?>

<?php
  session_start();
  if(!isset($_SESSION['admin_email_id'])){
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
      <title>Manage Users</title>
   </head>

   <body style="background-image: url(images/coffee1.jpg)">
   <header>
      <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
      <ul class="navigation">

                <li><form action="manageUsers.php" method="post" enctype="multipart/form-data">
                  <input type="search" name="searchText" placeholder="Search.." id="searchText"
                    style="height: 30px; width: 60%; outline: none; padding-left: 15px; border: 1px solid lightgrey; border-bottom-width: 2px; font-size: 17px;" required>
                    <a><button name="search" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;">    
                      <span class="hoverText">Search by Name</span>
                      <i class="fa fa-search"></i>
                    </button></a>
                </form></li>
              
                <li style="width:40%"><form action="manageUsers.php" method="post" enctype="multipart/form-data">
                    <select id="sort" name="sortText" size="1" 
                    style="height: 30px; width: 60%; outline: none; padding-left: 15px; border: 1px solid lightgrey; border-bottom-width: 2px; font-size: 17px;" required>
                        <option value="Name">Name</option>
                        <option value="Email_ID">Email ID</option>
                    </select>
                    <a><button name="sort" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;">
                      <span class="hoverText">Sort By</span>
                      <i class="fa fa-sort"></i>
                    </button></a>
                </form></li>
              
                <li><a><button style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;" onclick="addNewUser()">
                    <span class="hoverText">Add A New User</span>
                    <i class="fa fa-user-plus"></i>
                </button></a></li>
              <script>
                function addNewUser() {
                  window.location.href="addNewUser.php";
                }
              </script>
              
        <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
      </ul>
    </header>

      <div id="users" class="users">
        <section class="users">
        <div class="title">
            <h2 class="title-text">Manage <span>Users</span></h2>
        </div>
  
        <div id="list">
          <?php 
            if($toSearch){
          ?>

        <table style="border:5px solid #60371E; width:100%;" bgcolor="#FFD7A0">
          <tr style="outline:3px solid #60371E; color:#60371E; font-size:25px;" class="displayTitle">
            <th>Username</th>
            <th>Contact No.</th>
            <th>Email-ID</th>
            <th> </th>
          </tr>

          <?php
            while($rows4 = mysqli_fetch_array($result4)){
          ?>

          <tr style="outline:3px solid #60371E; text-align:center; color:#60371E;" class="displayData">
            <td style="text-align:center; font-size:20px;"><?php echo $rows4['full_name'];?></td>
            <td style="text-align:center; font-size:20px;"><?php echo $rows4['contact_number'];?></td>
            <td style="text-align:center; font-size:20px;"><?php echo $rows4['email_id'];?></td>
            <td>
              <form action="editUser.php?user_id=<?php echo $rows4['user_id']?>" id="edit" method="post">
                <a href="editUser.php?user_id=<?php echo $rows4['user_id']?>">
                  <input type="submit" name="edit" value="&#9998;" id="<?php echo $rows4['user_id'];?>" style="font-size:24px; width:50px; border: black solid; background-color:#6ffc8e;">
                </a>
              </form>
            </td>
            <td>
            <form action="managaeUsers.php?user_id=<?php echo $rows4['user_id']?>" id="delete" method="post">
                <a href="manageUsers.php?user_id=<?php echo $rows4['user_id']?>">
                    <input type="submit" name="delete" value="&#10006;" id="<?php echo $rows4['user_id'];?>" style="font-size:24px; width:50px; border: black solid; background-color:#f51637;">
                </a>  
              </form>
            </td>
          </tr>
          
          <?php
              }
          ?>
          </table>

          <?php
            } else if($toSort){
          ?>

        <table style="border:5px solid #60371E; width:100%;" bgcolor="#FFD7A0">
          <tr style="outline:3px solid #60371E; color:#60371E; font-size:25px;" class="displayTitle">
            <th>Username</th>
            <th>Contact No.</th>
            <th>Email-ID</th>
            <th> </th>
          </tr>

          <?php
            while($rows5 = mysqli_fetch_array($result5)){
          ?>

          <tr style="outline:3px solid #60371E; text-align:center; color:#60371E;" class="displayData">
            <td style="text-align:center; font-size:20px;"><?php echo $rows5['full_name'];?></td>
            <td style="text-align:center; font-size:20px;"><?php echo $rows5['contact_number'];?></td>
            <td style="text-align:center; font-size:20px;"><?php echo $rows5['email_id'];?></td>
            <td>
              <form action="editUser.php?user_id=<?php echo $rows5['user_id']?>" id="edit" method="post">
                <a href="editUser.php?user_id=<?php echo $rows5['user_id']?>">
                  <input type="submit" name="edit" value="&#9998;" id="<?php echo $rows5['user_id'];?>" style="font-size:24px; width:50px; border: black solid; background-color:#6ffc8e;">
                </a>
              </form>
            </td>
            <td>
            <form action="managaeUsers.php?user_id=<?php echo $rows5['user_id']?>" id="delete" method="post">
                <a href="manageUsers.php?user_id=<?php echo $rows5['user_id']?>">
                    <input type="submit" name="delete" value="&#10006;" id="<?php echo $rows5['user_id'];?>" style="font-size:24px; width:50px; border: black solid; background-color:#f51637;">
                </a>  
              </form>
            </td>
          </tr>
          <?php
              }
          ?>
        </table>

          <?php 
            } else{
          ?>

        <table style="border:5px solid #60371E; width:100%;" bgcolor="#FFD7A0">
          <tr style="outline:3px solid #60371E; color:#60371E; font-size:25px;" class="displayTitle">
            <th>Username</th>
            <th>Contact No.</th>
            <th>Email-ID</th>
            <th> </th>
          </tr>
          <?php
            while($rows1 = mysqli_fetch_array($result1)){
          ?>

          <tr style="outline:3px solid #60371E; text-align:center; color:#60371E;" class="displayData">
            <td style="text-align:center; font-size:20px;"><?php echo $rows1['full_name'];?></td>
            <td style="text-align:center; font-size:20px;"><?php echo $rows1['contact_number'];?></td>
            <td style="text-align:center; font-size:20px;"><?php echo $rows1['email_id'];?></td>
            <td>
              <form action="editUser.php?user_id=<?php echo $rows1['user_id']?>" id="edit" method="post">
                <a href="editUser.php?user_id=<?php echo $rows1['user_id']?>">
                  <input type="submit" name="edit" value="&#9998;" id="<?php echo $rows1['user_id'];?>" style="font-size:24px; width:50px; border: black solid; background-color:#6ffc8e;">
                </a>
              </form>
            </td>
            <td>
            <form action="managaeUsers.php?user_id=<?php echo $rows1['user_id']?>" id="delete" method="post">
                <a href="manageUsers.php?user_id=<?php echo $rows1['user_id']?>">
                    <input type="submit" name="delete" value="&#10006;" id="<?php echo $rows1['user_id'];?>" style="font-size:24px; width:50px; border: black solid; background-color:#f51637;">
                </a>  
              </form>
            </td>
          </tr>
          <?php
            }
          ?>
          </table>
          <?php
            }
          ?>
        </div>
        </section>
      </div>

   </body>
</html>