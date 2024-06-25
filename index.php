<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Booking</title>
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script>
</head>
<body>
    <div class="navbar" id="nav">
        <?php
            if(isset($_SESSION['user'])) {
        ?>  <a href="login.php" id="login_logout">Logout</a>
        <?php    
            }else{        
        ?>   <a href="login.php" id="login_logout">Login</a>
        <?php
            }
        ?>
        
        <a href="create_listing.html">Create Listing</a>
        <a href="index.php" class="feed">Feed</a>
    </div>
    


    <div id="listings">
        <div class="listing">
            HELLO
        </div>
    </div>
    
    <footer id="footer">
        <div class="contact">
            <h3>Contact Us</h3>
            <p>University of Piraeus</p>
            <p><a href="tel:+302104142000">+302104142000</a></p>
            <p><a href="mailto:info@unipi.gr">info@unipi.gr</a></p>
            <p>Karaoli ke Dimitriou 80, Pireas 185 34</p>
        </div>
       
        <div class="map">
            <h3>Our Location</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12585.262210580891!2d23.6575748!3d37.9464174!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bbe5bb8515a1%3A0x3e0dce8e58812705!2sUniversity%20of%20Piraeus!5e0!3m2!1sen!2sgr!4v1719093655231!5m2!1sen!2sgr" width="700" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </footer> 
</body>
</html>