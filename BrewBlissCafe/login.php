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

if(isset($_POST['full_name'])){
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
         window.onload = function () { alert("Account registered. Please login."); }
         </script>';  
      } else {
         echo "ERROR: $sql <br> $con->error";
      }
   }
}
      
session_start();
   
if(isset($_POST['Login'])) {
// username and password sent from form
   $email = $_POST['email'];
   $pass = $_POST['pass'];

   $email = stripcslashes($email);
   $pass = stripcslashes($pass);
   $email = mysqli_real_escape_string($con, $email);
   $pass = mysqli_real_escape_string($con, $pass); 
   $pass = md5($pass);

   $sql = "SELECT * FROM users WHERE email_id = '$email' and password = '$pass'";
   $result = mysqli_query($con, $sql);
   $row = mysqli_fetch_array($result,  MYSQLI_ASSOC);
   $count = mysqli_num_rows($result);
		
   if($count == 1) {
      //$_SESSION['email_id'] = $row['email_id'];
      //$id = $row['id'];
      $name = $row['full_name'];
      
      $_SESSION['full_name'] = $name;
      $_SESSION['email_id'] = $email;
      //$_SESSION['active'] = true;
      header("location: home.php");
   } else {
      $error = "Your Login Name or Password is invalid";
      echo '<script type="text/javascript">
         window.onload = function () { alert("Your Login Name or Password is invalid!"); }
         </script>';        
   }

   $sql1 = "SELECT * FROM cafe_admin WHERE admin_email_id = '$email' and admin_password = '$pass'";
   $result1 = mysqli_query($con, $sql1);
   $row1 = mysqli_fetch_array($result1,  MYSQLI_ASSOC);
   $count1 = mysqli_num_rows($result1);
		
   if($count1 == 1) {
      //$id = $row['id'];
      $name = $row1['admin_full_name'];
      $_SESSION['admin_full_name'] = $name;      
      $_SESSION['admin_email_id'] = $email;
      if($email == $row1['admin_email_id'] && $pass == $row1['admin_password']){
         header("location: adminHomepage.php");
      }
   }
}

// Close the database connection
$con->close();
?>


<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title>Login and Registration Form</title>
   </head>
   
   <body>
      <header>
         <a href="#" class="logo">Welcome to <strong>Brew Bliss Café <i class="fa fa-coffee"></i></strong></a>
      </header>

      <div class="wrapper">
         <div class="title-text">
            <div class="title login">
               Login Form
            </div>
            <div class="title signup">
               Signup Form
            </div>
         </div>
         <div class="form-container">
            <div class="slide-controls">
               <input type="radio" name="slide" id="login" checked>
               <input type="radio" name="slide" id="signup">
               <label for="login" class="slide login">Login</label>
               <label for="signup" class="slide signup">Signup</label>
               <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
               <form action="" method="post" class="login"><br>
                  <div class="field">
                     <input type="email" placeholder="Email Address" name="email" required>
                  </div>
                  <div class="field">
                     <input type="password" placeholder="Password" name="pass" required>
                  </div><br><br>
                  <div class="field btn">
                     <div class="btn-layer"></div>
                     <input type="submit" value="Login" name="Login">
                  </div>
                  <div class="signup-link">
                     Not a member? <a href="">Signup now</a>
                  </div>
               </form>

               <form action="login.php" method="post" class="signup">
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
      <script>
         const loginText = document.querySelector(".title-text .login");
         const loginForm = document.querySelector("form.login");
         const loginBtn = document.querySelector("label.login");
         const signupBtn = document.querySelector("label.signup");
         const signupLink = document.querySelector("form .signup-link a");
         signupBtn.onclick = (()=>{
           loginForm.style.marginLeft = "-50%";
           loginText.style.marginLeft = "-50%";
         });
         loginBtn.onclick = (()=>{
           loginForm.style.marginLeft = "0%";
           loginText.style.marginLeft = "0%";
         });
         signupLink.onclick = (()=>{
           signupBtn.click();
           return false;
         });
      </script>
   </body>
</html>