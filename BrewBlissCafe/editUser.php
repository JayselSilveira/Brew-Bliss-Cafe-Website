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

  $sql = "SELECT * FROM users;";
  $result = $con->query($sql);

  
  $user_id = $_GET['user_id'];

  if(isset($_POST['update'])){
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $email_id = $_POST['email_id'];

    $email_id = stripcslashes($email_id);
    $email_id = mysqli_real_escape_string($con, $email_id);

    $sql1 = "UPDATE users SET full_name = '$full_name', contact_number = '$contact_number', email_id = '$email_id' WHERE user_id = '$user_id';";

    if($con->query($sql1) == true){
        header("location: manageUsers.php");
        echo '<script type="text/javascript">
            window.onload = function () { alert("User information updated successfully."); }
        </script>';  
     } else {
        echo "ERROR: $sql1 <br> $con->error";
     }
  }

  // Close the database connection
  $con->close();
?>

<?php
  session_start();
  if(!isset($_SESSION['admin_full_name'])){
    header("location: login.php");
  }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="edit.css">
    <title>Edit User</title>
</head>

<body background="./images/desserts1.webp">
    <div class="card" style="height: 62%;">
        <div>
            <h4><a href="http://localhost/BrewBlissCafe/manageUsers.php" style="color:#60371E; margin-left:190px;">Manage Users</a></h4><hr style="margin-bottom:10px;">
            <h2>Edit User</h2>
        </div>
        <hr style="margin-bottom:10px;">
        <?php
            while($rows = mysqli_fetch_array($result)){
               if($rows['user_id'] == $user_id){
          ?>
        <div class="form"></div>
        <form action="editUser.php?user_id=<?php echo $rows['user_id']?>" method="post" class="edit" enctype="multipart/form-data">
            <div class="field">
                <p>User Name: 
                    <input type="text" value="<?php echo $rows['full_name'];?>" name="full_name" required>
                </p>
            </div>
            <div class="field">
                <p>Contact Number: 
                     <input type="tel" maxlength="10" value="<?php echo $rows['contact_number'];?>" name="contact_number" required>
                </p>
            </div>
            <div class="field">
                <p>Email-ID: 
                     <input type="email" value="<?php echo $rows['email_id'];?>" name="email_id" required>
                </p>
            </div>
            <div class="btn">
                <input type="submit" value="Save Changes" name="update">
            </div>
        </form>
    </div>
    <?php
}
}
?>
</body>

</html>