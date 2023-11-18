<?php
$insert = false;

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

if(isset($_POST['Signup'])){
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $email_id = $_POST['email_id'];
    $password = $_POST['password'];
 
    $email_id = stripcslashes($email_id);
    $email_id = mysqli_real_escape_string($con, $email_id);
    
    $password = stripcslashes($password);
    $password = mysqli_real_escape_string($con, $password); 
    $password = md5($password);
 
    $sql2 = "SELECT * FROM users WHERE email_id = '$email_id';";
    $result2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_array($result2,  MYSQLI_ASSOC);
      
    $count2 = mysqli_num_rows($result2);
         
    if($count2 == 1) {
       $error = "User with the entered email-id has already been registered.";
       echo '<script type="text/javascript">
          window.onload = function () { alert("User with the entered email-id has already been registered."); }
          </script>';  
    } else {
       $sql = "INSERT INTO users(full_name, contact_number, email_id, password) VALUES('$full_name', '$contact_number', '$email_id', '$password');";
       // Execute the query
       if($con->query($sql) == true){
          // Flag for successful insertion
          $insert = true;
          echo '<script type="text/javascript">
          window.onload = function () { alert("Account registered."); }
          </script>';  
          header("location: manageUsers.php");
       } else {
          echo "ERROR: $sql <br> $con->error";
       }
    }
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
      <link rel="stylesheet" href="addNewUser.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title>Add a New User</title>
   </head>
   
   <body>
   <header>
      <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
      <ul class="navigation">
        <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
      </ul>
    </header>

      <div class="wrapper" style="height: 65%; margin-top: 90px">
         <div class="title-text">
            <div class="title signup">
               Add a New User
            </div>
         </div>
         <div class="form-container">
            <div class="form-inner">
            <form action="" method="post" class="signup">
                  <div class="field">
                     <input type="text" placeholder="Full Name" name="full_name" required>
                  </div>
                  <div class="field">
                     <input type="tel" maxlength="10" placeholder="Contact Number" name="contact_number" required>
                  </div>
                  <div class="field">
                     <input type="email" placeholder="Email Address" name="email_id" required>
                  </div>
                  <div class="field">
                     <input type="password" placeholder="Password" name="password" required>
                  </div>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="Signup" name="Signup">
                  </div>
               </form>
            </div>
         </div>
      </div>      
   </body>
</html>