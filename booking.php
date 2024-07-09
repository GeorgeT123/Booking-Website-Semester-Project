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
        <a href="index.php">Feed</a>
    </div>
    
    <?php //$listing_id = $_SESSION["listing"]; 
        $listing_id = $_GET['id'];
        echo $listing_id;  
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
            <form method="post" id="booking-dates">
                <div style="display:flex; flex-direction: row; gap:2em; margin:2em;">
                    <label for="date_from"><b>Date From</b></label>
                    <input type="date" name="date_from" style="width:65%; text-align:center;" id="date_from" required>
                    <label for="date_from"><b>Date To</b></label>
                    <input type="date" name="date_to" style="width:65%; text-align:center;" id="date_to" required>
                    <input type="submit" value="Continue" id="continue-button">
                    <!-- <button id="continue-button" onclick="location.href='booking.php'" style="background-color: #64418f; color:white; font-weight: bold; cursor: pointer; width:100%; height:3em;">Continue</button> -->
                </div>  <!-- make this with on click button and check on js? right now it is one big form!!! -->
            <!-- </form> -->
                <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST") {
                        $date_from = $_POST['date_from'];
                        $date_to = $_POST['date_to'];

                        if($date_from < $date_to){
                            // Check for availability
                            $sql = "SELECT COUNT(*) FROM reservations WHERE (date_from <= '$date_to' AND date_to >= '$date_from')";
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
                                // document.getElementById('booking-dates').style.display = 'none';
                                document.getElementById('continue-button').style.display = 'none';
                            </script>
                            <!-- <form method="post"> -->
                                <div id="booking-user">
                                    <!-- <div style="display:flex; flex-direction: row; gap:2em; margin:2em;">
                                        <label for="date_from"><b>Date From</b></label>
                                        <input type="date" name="date_from" style="width:65%; text-align:center;" id="date_from" required>
                                        <label for="date_from"><b>Date To</b></label>
                                        <input type="date" name="date_to" style="width:65%; text-align:center;" id="date_to" required>
                                    </div> -->
                                    <input type="text" name="fname" placeholder="First Name" value="<?php echo $fname; ?>" required>
                                    <input type="text" name="lname" placeholder="Last Name" value="<?php echo $lname; ?>" required>
                                    <input type="email" name="email" placeholder="E-Mail" value="<?php echo $email; ?>" required>
                                    <input type="hidden" name="temp" value="null">
                                    <input type="submit" name="book" value="Book Now">
                                </div>
                            </form>
                            <style> #continue-button {display:none;} </style>
                        <?php     
                            //CALCULATE TOTAL PRICE 
                            // $date_from = json_encode($date_from); 
                            // $date_to = json_encode($date_to);
                            // $price = json_encode($price);
                            // echo "<script>price_calculator($price, $date_from, $date_to);</script>";
                            $discount = rand(10,30)/100;
                            $from = new DateTime($date_from);//date('d', strtotime($date_from));
                            $to = new DateTime($date_to);//date('d', strtotime($date_to));
                            $num_of_days = ($from->diff($to))->days+1;//$to - $from;
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
    $temp = $_POST['temp'];
    if($_SERVER["REQUEST_METHOD"] == "POST" && $temp) {   
    //    $counter++;
    //    if($counter==2){ 
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        // $date_from = $_POST['date_from'];
        // $date_to = $_POST['date_to'];

        $sql = "INSERT INTO reservations (fname, lname, email, date_from, date_to, total_price) VALUES (:fname, :lname, :email, :date_from, :date_to, :total_price)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':date_from', $date_from);
        $stmt->bindParam(':date_to', $date_to);
        $stmt->bindParam(':total_price', $total_price);

        $stmt->execute();

        echo "<script>booking_success();</script>";
        // echo '<h2 style="text-align:center;">Booking succesful. Thanks for your patronage.</h2>';

        // header("Location: index.php");
        exit();
    //    }
    }
        // $date_from = $_POST['date_from'];
        // $date_to = $_POST['date_to'];

        // echo $date_from < $date_to;
        // // Check if the dates already exists
        // $sql = "SELECT COUNT(*) FROM reservations WHERE date_from = :date_from";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute(['date_from' => $date_from]);
        // $dateExists = $stmt->fetchColumn();

        // $sql = "SELECT COUNT(*) FROM reservations WHERE date_to = :date_to";
        // $stmt = $conn->prepare($sql);
        // $stmt->execute(['date_to' => $date_to]);
        // $dateExists = $stmt->fetchColumn();
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