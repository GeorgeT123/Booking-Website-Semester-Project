<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Listing</title>
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
                    
            <a href="create_listing.php" class="create_listing">Create Listing</a>
            <a href="index.php">Feed</a>
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
                <li><a href="create_listing.php" class="create_listing">Create Listing</a></li>
                <li><a href="index.php">Feed</a></li>
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

        if(isset($_SESSION['user'])) {
    ?>    
    <div id="create">
        <div id="create-listing">
            <form id="listingForm" method="POST" enctype="multipart/form-data">
                <label for="photo">Listing photo:</label>
                <input type="file" name="photo" accept="image/*" required>

                <label for="title">Title:</label>
                <input type="text" name="title" pattern="[A-Za-z\s]+" required>

                <label for="location">Location:</label>
                <input type="text" name="location" pattern="[A-Za-z\s]+" required>

                <label for="rooms">Number of rooms:</label>
                <input type="number" name="rooms" min="1" max="20" pattern="[1-9\s]+" required>

                <label for="price">Price per night:</label>
                <input type="number" name="price" min="1" required>

                <input type="submit" value="Create listing">
            </form>
        </div>
    </div>
    <?php    
            }else{        
    ?>   
    <div id="create">
        <b style="text-align: center;">PLEASE <a href="login.php">LOGIN</a> TO ACCESS THIS PAGE</b> 
    </div>
    <?php
        }
    ?>
    
    <?php
        $sql = "SELECT id FROM listings ORDER BY ID DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // Fetch all rows
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $listing_id = $row['id']+1;
        }
        $path_name = "img\listing". $listing_id .".jpg";
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            move_uploaded_file($_FILES["photo"]["tmp_name"], $path_name);
            $title = $_POST['title'];
            $location = $_POST['location'];
            $rooms = $_POST['rooms'];
            $price_per_night = $_POST['price'];

            $sql = "INSERT INTO listings (title, location, rooms, price, image) VALUES (:title, :location, :rooms, :price, :image)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':rooms', $rooms);
            $stmt->bindParam(':price', $price_per_night);
            $stmt->bindParam(':image', $path_name);

            $stmt->execute();
            
            echo "<script>listing_creation();</script>";

            exit();
        }
    ?>
    
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