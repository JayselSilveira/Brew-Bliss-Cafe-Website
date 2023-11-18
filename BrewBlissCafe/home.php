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

if(isset($_POST['first_name'])){   
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email_id'];
    $experience = $_POST['experience'];

    $sql = "INSERT INTO contact_us(first_name, last_name, email_id, experience) VALUES('$first_name', '$last_name', '$email', '$experience');";
        
    // Execute the query
    if($con->query($sql) == true){
        // Flag for successful insertion
        $insert = true;
        echo '<script type="text/javascript">
         window.onload = function () { alert("Message sent!"); }
         </script>';  
    }
    else{
        echo "ERROR: $sql <br> $con->error";
    }
}

$sql1 = "SELECT * FROM popular_cafe_offerings WHERE offering_id = 1;";
$result1 = $con->query($sql1);
$row1 = mysqli_fetch_array($result1,  MYSQLI_ASSOC);
$value1 = $row1['item_id'];

$sql2 = "SELECT * FROM popular_cafe_offerings WHERE offering_id = 2;";
$result2 = $con->query($sql2);
$row2 = mysqli_fetch_array($result2,  MYSQLI_ASSOC);
$value2 = $row2['item_id'];

$sql3 = "SELECT * FROM coffees WHERE item_id = $value1";
$result3 = $con->query($sql3);
$row3 = mysqli_fetch_array($result3,  MYSQLI_ASSOC);

$sql4 = "SELECT * FROM desserts WHERE item_id = $value2";
$result4 = $con->query($sql4);
$row4 = mysqli_fetch_array($result4,  MYSQLI_ASSOC);

session_start();
$email_id = $_SESSION['email_id'];
$sql5 = "SELECT * FROM users WHERE email_id = '$email_id'";
$result5 = $con->query($sql5);
$row5 = mysqli_fetch_array($result5,  MYSQLI_ASSOC);

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
    <meta charset="UTF-8">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Brew Bliss Café</title>
  </head>

  <body>
    <header>
      <a href="#" class="logo">Brew Bliss Café <i class="fa fa-coffee"></i></a>
      <ul class="navigation">
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="http://localhost/BrewBlissCafe/menu.php">Menu</a></li>
        <li><a href="#testimonials">Testimonials</a></li>
        <li><a href="#contactUs">ContactUs</a></li>
        <li><a href="http://localhost/BrewBlissCafe/cart.php?user_id=<?php echo $row5['user_id'];?>" style="font-size: 23px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;">&#128722;</a></li>
        <li><form method="post"><a><input type="submit" id="logout" name="logout" value="Logout" style="font-size: 20px; font-weight: 600; color: #FFD7A0; background: #60371E; padding: 2px 20px;
            margin-left: 10px;"></a></form></li>
      </ul>
    </header>

    <section class="home" id="home" style="background-image: url(images/coffeebg2.jpg); width:1518px">
      <div class="content">

      <h2 style="text-align: center; font-size: 25px; padding-bottom: 30px; color: #FFD7A0">Welcome <?php echo $_SESSION['full_name'];?>!</h2>

        <h2>"<span>Coffee</span> is a language in itself."</h2><br>
        <p> - Jackie Chan</p><br>
        <h3>
          "Caffeine Haven: Where Every Sip is an Experience"
        </h3><br>
        <a href="http://localhost/BrewBlissCafe/menu.php" class="btn">Let's order!</a>
      </div>
    </section>

    <section class="about" id="about">
      <div class="row">
        <div class="col">
          <h2 class="title-text">About <span>Us</span></h2>
          <p>
            <br>
            Welcome to Brew Bliss Café, where every cup tells a story.

            At Brew Bliss Café, we're more than just a coffee shop; we're a community hub, a place where friends gather, 
            and strangers become friends over the shared love of exceptional coffee. Our journey began with a simple belief: 
            that a cup of coffee has the power to inspire, connect, and create memorable moments.
            <br>
            <br>
            <b>Our Coffee Philosophy</b><br>
            We are passionate about the art of coffee. Our beans are carefully sourced from the world's most renowned coffee 
            regions, ensuring that every sip you take is a journey to a different part of the globe. From the moment the beans 
            arrive at our door to the precise brewing methods, we put unwavering dedication into every step. We don't just serve 
            coffee; we serve an experience, a moment of joy, and a taste of the extraordinary.
            <br>
            <br>
            <b>Our Space</b><br>
            Step inside Brew Bliss Café, and you'll find a warm and inviting atmosphere. Our cozy seating, handpicked decor, 
            and the aroma of freshly roasted beans create a space that invites you to relax, work, socialize, or simply savor 
            your coffee. It's a place where creativity flows, and inspiration strikes.
            <br>
            <br>
            <b>Our Team</b><br>
            The heart and soul of Brew Bliss Café are our friendly and knowledgeable baristas. They're passionate about coffee, 
            and their craft is not just in brewing but in creating connections with each customer. Whether you're a regular or a 
            first-time visitor, you'll always be met with a warm smile and a personalized recommendation.
            <br>
            <br>
            <b>Community and Sustainability</b><br>
            Beyond great coffee, we believe in giving back to the community and protecting the planet. We actively engage in local initiatives, 
            support local artists, and prioritize sustainable practices in our cafe operations.
            <br>
            <br>
            <b>Join Us</b><br>
            We invite you to be part of our Brew Bliss Café community. Whether you're here for your daily caffeine fix, to meet a friend, 
            to work remotely, or simply to enjoy a moment of tranquility, we're delighted to have you. Together, let's savor life, one cup at a time.
            <br><br>
            Thank you for choosing Brew Bliss Café as your coffee destination. We can't wait to share a cup of something special with you.
          </p>
        </div>
      </div>
    </section>

    <section class="menu" id="menu" style="background: #FFD7A0; background-image: url(images/footer_image.jpg)">
      <div class="title">
        <h2 class="title-text">Popular <span>Café</span> offerings</h2>
      </div>
      <div class="content">
        
          <div class="card" style="background: #FFD7A0;">
            <a href="http://localhost/BrewBlissCafe/itemCoffees.php?item_id=<?php echo $row3['item_id'];?>" class="card-links">
            <div class="imgBx">
              <img src="./uploadedImages/menu/coffees/<?php echo $row3['item_image'];?>" alt="Popular Coffee Image" style="object-fit:contain;">
            </div>
            <div class="text">
              <h3><?php echo $row3['item_name'];?></h3>
            </div></a>
          </div>       
         
        <div class="card" style="background: #FFD7A0;">
          <a href="http://localhost/BrewBlissCafe/itemDesserts.php?item_id=<?php echo $row4['item_id'];?>" class="card-links"></a>
        </a>
          <div class="imgBx">
            <img src="./uploadedImages/menu/desserts/<?php echo $row4['item_image'];?>" alt="Popular Dessert Image" style="object-fit:contain;">
          </div>
          <div class="text">
            <h3><?php echo $row4['item_name'];?></h3>
          </div>
        </div>
      </div>
      <p style="text-align: center;"><a href="menu.php" class="btn">Let's order!</a></p>
    </section>

    <section class="testimonials" id="testimonials">
      <div class="title">
        <h2 class="title-text"><span>T</span>estimonials</h2>
      </div>

      <div class="container">

      <div class="indicator">
        <span class="testiBtn active" id="btn1"></span>
        <span class="testiBtn" id="btn2" ></span>
        <span class="testiBtn" id="btn3"></span>
        <span class="testiBtn" id="btn4"></span>
      </div>

      <div class="testimonial">

        <div class="slide-row" id="slide">
          <div class="slide-col">
            <div class="user-text">
              <p>"Brew Bliss Cafe is my go-to spot for a perfect cup of coffee. The atmosphere is so inviting and cozy; it's my escape from the daily hustle. 
                The coffee is always spot on, and the staff is friendly. It's a place where I can truly relax and enjoy the moment."</p>
                <h3>Sarah J.</h3>
              <p>Panjim, Goa</p>
            </div>
            <div class="user-image">
              <img src="./Images/testi1.jpg">
            </div>
          </div>

          <div class="slide-col">
            <div class="user-text">
              <p>"I stumbled upon Brew Bliss Cafe during a morning walk, and it's become a regular stop for me. Their pastries are to die for, and the coffee 
                is just amazing."</p>
              <h3>John D.</h3>
              <p>Dona Paula, Goa</p>
            </div>
            <div class="user-image">
             <img src="./Images/testi2.jpg">
            </div>
          </div>

          <div class="slide-col">
            <div class="user-text">
              <p>"I recently hosted a business meeting at Brew Bliss Cafe, and it was a fantastic experience. The staff was incredibly accommodating, 
                and the coffee was a hit with my clients. The location is central, making it a convenient meeting point."</p>
              <h3>Emily S.</h3>
              <p>Margao, Goa</p>
            </div>
            <div class="user-image">
              <img src="./Images/testi3.jpg">
            </div>
          </div>  

          <div class="slide-col">
            <div class="user-text">
              <p>"I celebrated my birthday at Brew Bliss Cafe, and it was a memorable experience. 
                The desserts were divine, and the cafe's unique charm created the perfect backdrop for a wonderful celebration."</p>
                <h3>Lisa H.</h3>
              <p>Panjim, Goa</p>
            </div>
            <div class="user-image">
              <img src="./Images/testi4.jpg">
            </div>
          </div>

          <div class="slide-col">
            <div class="user-text">
              <p>I would like to thank Tourist's Stop for organising wonderful tour for us in Goa. 
                Everything was very well organised. Thank you very much for everything!</p>
              <h3>George Brown</h3>
              <p>Oxford, United Kingdom</p>
            </div>
            <div class="user-image">
              <img src="./Images/testi5.jpg">
            </div>
          </div>

        </div>
      </div>

      </div>

      <script>
        var btn1= document.getElementById('btn1'); 
        var btn2= document.getElementById('btn2'); 
        var btn3= document.getElementById('btn3'); 
        var btn4= document.getElementById('btn4'); 
        var slide = document.getElementById('slide'); 

        btn1.onclick = function(){ 
          slide.style.transform = "translateX(0px)"; 
          btn1.classList.add("active"); 
          btn2.classList.remove("active"); 
          btn3.classList.remove("active"); 
          btn4.classList.remove("active"); 
        } 

        btn2.onclick = function(){ 
          slide.style.transform = "translateX(-800px)"; 
          btn1.classList.remove("active"); 
          btn2.classList.add("active"); 
          btn3.classList.remove("active"); 
          btn4.classList.remove("active") 
        } 

        btn3.onclick = function(){ 
          slide.style.transform = "translateX(-1600px)"; 
          btn1.classList.remove("active"); 
          btn2.classList.remove("active"); 
          btn3.classList.add("active"); 
          btn4.classList.remove("active") 
        } 

        btn4.onclick = function(){ 
          slide.style.transform = "translateX(-2400px)"; 
          btn1.classList.remove("active"); 
          btn2.classList.remove("active"); 
          btn3.classList.remove("active"); 
          btn4.classList.add("active") 
        } 
      </script>

    </section>

    <section class="contactUs" id="contactUs" style="background: #FFD7A0; background-image: url('./images/coffee.jpeg'); background-size: 50%; background-position: right; background-repeat: no-repeat;">
        <div class="title">
            <h2 class="title-text" style="text-shadow: 0 0 3px #60371E;">Contact <span>Us</span></h2>
        </div>
        <div class="contactForm">
          <h3>Send Message</h3>
        <form action="home.php" method="post">
          <div class="inputBox">
            <input type="text" placeholder="First Name" name="first_name" required>
          </div>
  
          <div class="inputBox">
            <input type="text" placeholder="Last Name" name="last_name" required>
          </div>
  
          <div class="inputBox">
            <input type="text" placeholder="Email" name="email_id" required>
          </div>
  
          <div class="inputBox">
            <textarea type="text" placeholder="Share your experience" name="experience" required></textarea>
          </div>
  
          <div class="inputBox">
            <input type="submit" placeholder="Get in touch!" name="submit" value="SUBMIT">
          </div>
        </form>
        </div>
        
        <div class="emailUs">
          <p>Contact Us At: +91 9876543210</p>
          <p>Email Us At: brewblisscafe@gmail.com</p>
        </div>
    </section>

  <section class="footer">
    <div class="box-container">
      <div class="box">
          <h3>Branch Locations</h3>
          <a href="#">India</a>
          <a href="#">USA</a>
          <a href="#">Japan</a>
          <a href="#">France</a>
      </div>
      <div class="box">
          <h3>Quick Links</h3>
          <a href="#home">Home</a>
          <a href="http://localhost/BrewBlissCafe/menu.php">Menu</a>
          <a href="#testimonials">Testimonials</a>
          <a href="#contactUs">ContactUs</a>
      </div>
      <div class="box">
          <h3>Follow Us</h3>
          <a href="#">Facebook</a>
          <a href="#">Instagram</a>
          <a href="#">Twitter</a>
          <a href="#">LinkedIn</a>
      </div>
      <div class="box">
          <h2 class="title-text"><span>A</span>bout Us</h2>
          <p>At Brew Bliss Cafe, we're passionate about two things: great coffee and exceptional experiences. Our cozy space is designed for you to escape, 
            relax, and savor every sip. We source the finest beans, craft delightful treats, and provide a welcoming haven for friends and strangers alike. 
            Join us in celebrating the simple joy of coffee and connection.
            <br><br>
            Explore, linger, and let your day bloom with Brew Bliss.
          </p>
      </div>
    </div>
    <h1 class="credit">@www.brewblisscafe.com</h1>
  </section>

  </body>
</html>
