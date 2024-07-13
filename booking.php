<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Property</title>
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script>
</head>
<body>

    <?php
    //initiate db connection
    $servername = "mysql:host=127.0.0.1; dbname=ds_estate";
    $username= "root";
    $password = "";
    try {
        // Create a PDO instance
        $conn = new PDO ($servername, $username, $password); $conn->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $session_user = $_SESSION['user'];
        $sql = "SELECT fname, lname, email FROM users WHERE username='$session_user'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // Fetch all rows
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Connection failed:" . $e->getMessage();
    }
    ?>

    <div class="navbar" id="nav">   
        <div class="desktop">
            <?php
                    //check if user is logged in
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
                        //check if user is logged in
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
        //get the id from the url and set the username from the session variable
        $listing_id = $_GET['id'];
        $username = $_SESSION["user"];
    ?>
        
    <div id="booking">
        <div class="listing">
            <?php
                // Prepare and execute query
                $sql = "SELECT title, location, rooms, price, image FROM listings WHERE id='$listing_id'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                // Fetch all rows
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //get the info from database to show chosen listing and pre fill user's info afterwards 
                foreach($result as $row){       
                    $photo = htmlspecialchars($row['image']);
                    $title = htmlspecialchars($row['title']);
                    $location = htmlspecialchars($row['location']);
                    $rooms = htmlspecialchars($row['rooms']);
                    $price = htmlspecialchars($row['price']);
                }     
                $sql = "SELECT fname, lname, email FROM users WHERE username='$username'";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                // Fetch all rows
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($result as $row){       
                    $fname = htmlspecialchars($row['fname']);
                    $lname = htmlspecialchars($row['lname']);
                    $email = htmlspecialchars($row['email']);
                }     
            ?>
            <img src="<?php echo $photo; ?>" alt="Hotel Image" class="listing-image"> <!--for images add 2 \ (\\) in path when saving to db -->
            <div class="listing-details">
                <h2 class="listing-title"><?php echo $title; ?></h2>
                <p class="listing-location"><?php echo $location; ?></p>
                <p class="listing-rooms">Rooms: <?php echo $rooms; ?></p>
                <p class="listing-price">€<?php echo $price; ?> per night</p>
            </div>
       </div>
       <div id="booking-form">
            <form method="post">
                <div id="booking-dates">
                    <label for="date_from"><b>Date From</b></label>
                    <input type="date" name="date_from" style="width:65%; text-align:center;" id="date_from" required>
                    <label for="date_from"><b>Date To</b></label>
                    <input type="date" name="date_to" style="width:65%; text-align:center;" id="date_to" required>
                    <input type="submit" value="Continue" id="continue-button">
                </div> 
                <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST") {
                        $date_from = $_POST['date_from'];
                        $date_to = $_POST['date_to'];

                        if($date_from < $date_to){
                            // Check for availability
                            $sql = "SELECT COUNT(*) FROM reservations WHERE (date_from <= '$date_to' AND date_to >= '$date_from' AND reservation_id = '$listing_id')";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            // Fetch all rows
                            $result = $stmt->fetchColumn();
                        ?>  
                            <script>
                                document.getElementById('date_from').value = "<?php echo $date_from ?>"
                                document.getElementById('date_to').value = "<?php echo $date_to ?>"
                            </script>
                        <?php
                            if ($result > 0) {
                                echo "<script>date_error();</script>";
                            } else { ?>
                            <script>
                                document.getElementById('continue-button').style.display = 'none';
                            </script>
                            <!-- <form method="post"> -->
                                <div id="booking-user">
                                    <input type="text" name="fname" placeholder="First Name" value="<?php echo $fname; ?>" required>
                                    <input type="text" name="lname" placeholder="Last Name" value="<?php echo $lname; ?>" required>
                                    <input type="email" name="email" placeholder="E-Mail" value="<?php echo $email; ?>" required>
                                    <input type="hidden" name="temp" value="null">
                                    <input type="submit" name="book" value="Book Now">
                                </div>
                            </form>
                            <style> #continue-button {display:none;} </style>
                        <?php     
                            //calculate total price for booking
                            $discount = rand(10,30)/100;
                            $from = new DateTime($date_from);
                            $to = new DateTime($date_to);
                            $num_of_days = ($from->diff($to))->days+1;
                            $total_price = ($price * $num_of_days) - ($price * $num_of_days)*$discount;

                            echo "<script>price_calculator($total_price);</script>";
                        }   
                        }
                        else {
                            echo "<script>date_error();</script>"; ?>
                            <?php
                        }
                    }
                ?>                  
       </div> 
    </div>

    <?php
    //temp is to make sure the code below is only run after the Book Now button is pressed
    $temp = $_POST['temp'];
    if($_SERVER["REQUEST_METHOD"] == "POST" && $temp) {   

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        
        //prepare sql and bind the variable to insert into db
        $sql = "INSERT INTO reservations (fname, lname, email, date_from, date_to, total_price, reservation_id) VALUES (:fname, :lname, :email, :date_from, :date_to, :total_price, :reservation_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':date_from', $date_from);
        $stmt->bindParam(':date_to', $date_to);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':reservation_id', $listing_id);

        $stmt->execute();

        echo "<script>booking_success();</script>";

        exit();
    }
    ?>
    
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