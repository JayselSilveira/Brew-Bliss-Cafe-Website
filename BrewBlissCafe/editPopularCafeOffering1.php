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

  $sql = "SELECT * FROM coffees;";
  $result = $con->query($sql);
  $result1 = $con->query($sql);

    if(isset($_POST['update'])){
        $in = split ("\-", $_POST['offering']); 
        $item_id = $in[0];
        $item_name = $in[1];
        $item_id = ltrim($item_id," ");
        $item_id = rtrim($item_id," ");
        $item_id = intval($item_id);
        $item_name = ltrim($item_name," ");
        $item_name = rtrim($item_name," ");

        $sql1 = "UPDATE popular_cafe_offerings SET item_id = $item_id, item_name = '$item_name' WHERE offering_id = 1;";
        if($con->query($sql1) == true){
            header("location: popularCafeOfferings.php");
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
    <title>Update Page</title>
</head>

<body background="./images/puffpastry.jpg">
    <div class="card" style="height: 50%;">
        <div>
            <h4><a href="http://localhost/BrewBlissCafe/popularCafeOfferings.php" style="color:#60371E; margin-left:165px;">Popular Cafe Offerings</a></h4><hr style="margin-bottom:10px;">
            <h2>Update Page</h2>
        </div>
        <hr style="margin-bottom:10px;">

        <div class="form"></div>
        <?php
            $temp = $_GET['item_id'];
            while($rows = mysqli_fetch_array($result)){
               if($rows['item_id'] == $temp){
          ?>
        <form action="editPopularCafeOffering1.php?item_id=<?php echo $rows['item_id']?>" method="post" class="update" enctype="multipart/form-data">
            <div class="field">
                <br>
                <label for="offering">Select a Coffee as a Popular Cafe Offering:</label><br><br>
                    <select id="offering" name="offering" size="1" style="height: 30px; width: 80%; padding-left: 15px; border: 1px solid lightgrey; border-bottom-width: 2px; font-size: 17px;" required>
                        <option value="" disabled selected>Select a Coffee</option>    
                        
                        <?php
                        while ($row = mysqli_fetch_array($result1,  MYSQLI_ASSOC)) 
                        {
                           echo '<option value=" '.$row['item_id']." - ".$row["item_name"].' "> '.$row["item_name"].' </option>';
                        }
                        ?>
                    </select><br><br>
            </div>
            <div class="btn">
                <a href="editPopularCafeOffering1.php?item_id=<?php echo $rows['item_id']?>"><input type="submit" value="Save Changes" name="update"></a>
            </div>
        </form>
    </div> 
    <?php
    }
}
?>
</body>
</html>