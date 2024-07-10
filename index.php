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
        <div class="desktop">
            <?php
                    if(isset($_SESSION['user'])) {
            ?>  <a href="login.php" id="login_logout">Logout</a>
            <?php    
                }else{        
            ?>   <a href="login.php" id="login_logout">Login</a>
            <?php
                }
            ?>
                    
            <a href="create_listing.php">Create Listing</a>
            <a href="index.php" class="feed">Feed</a>
        </div>

        <div class="mobile">
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <?php
                        if(isset($_SESSION['user'])) {
                ?>  <li><a href="login.php" id="login_logout">Logout</a></li>
                <?php    
                    }else{        
                ?>   <li><a href="login.php" id="login_logout">Login</a></li>
                <?php
                    }
                ?>
                <li><a href="create_listing.php">Create Listing</a></li>
                <li><a href="index.php" class="feed">Feed</a></li>
            </ul>
        </div>
    </div>

    <?php
    //initiate db connection
    $servername = "mysql:host=127.0.0.1; dbname=ds_estate";
    $username= "root";
    $password = "";
    try {
        // Create a PDO instance
        $conn = new PDO ($servername, $username, $password); $conn->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed:" . $e->getMessage();
    }
    ?>

    <div id="listings">   
            <?php
                // Prepare and execute query
                $sql = "SELECT id, title, location, rooms, price, image FROM listings";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() != 0) {
                    foreach($result as $row){
                        $photo = htmlspecialchars($row['image']);
                        $title = htmlspecialchars($row['title']);
                        $location = htmlspecialchars($row['location']);
                        $rooms = htmlspecialchars($row['rooms']);
                        $price = htmlspecialchars($row['price']);
                        $listing_id = htmlspecialchars($row['id']);
            ?>        <div class="listing">
                        <img src="<?php echo $photo; ?>" alt="Hotel Image" class="listing-image"> <!--for images add 2 \ (\\) in path when saving to db -->
                        <div class="listing-details">
                            <h2 class="listing-title"><?php echo $title; ?></h2>
                            <p class="listing-location"><?php echo $location; ?></p>
                            <p class="listing-rooms">Rooms: <?php echo $rooms; ?></p>
                            <p class="listing-price">€<?php echo $price; ?> per night</p>
                            
                            <?php
                                if(isset($_SESSION['user'])) {
                                $_SESSION['listing'] = $listing_id;
                            ?>   <button class="booking-button" onclick="location.href='booking.php?id=<?php echo $listing_id;?>'">Book Now</button>
                            <?php    
                                }else{        
                            ?>   <button class="booking-button" onclick="location.href='login.php'">Login to Book property</button>
                            <?php
                                } ?>
                        </div>
                      </div>
                <?php    }
                }
                else {
                    echo '<h2 style="text-align: center;">No listings were found.</h2>';
                }
            ?>
    </div>
    
    <footer id="footer">
        <div class="contact">
            <h3>Contact Us</h3>
            <p>University of Piraeus</p>
            <p><a href="tel:+302104142000">+302104142000</a></p>
            <p><a href="mailto:info@unipi.gr">info@unipi.gr</a></p>
            <p>Karaoli kai Dimitriou 80, Pireas 185 34</p>
        </div>
       
        <div class="map">
            <h3>Our Location</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12585.262210580891!2d23.6575748!3d37.9464174!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bbe5bb8515a1%3A0x3e0dce8e58812705!2sUniversity%20of%20Piraeus!5e0!3m2!1sen!2sgr!4v1719093655231!5m2!1sen!2sgr" width="700" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </footer> 
</body>
</html>