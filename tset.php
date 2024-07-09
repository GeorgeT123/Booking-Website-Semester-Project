<?php
    $servername = "mysql:host=127.0.0.1; dbname=ds_estate";
    $username= "root";
    $password = "";
    // try {
    //     // Create a PDO instance
    //     $conn = new PDO ($servername, $username, $password); $conn->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     // Prepare and execute query
    //     $sql = "SELECT fname, lname, username, email, password FROM users";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute();
    //     // Fetch all rows
    //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     if (!empty($result)) {
    //         foreach ($result as $row) {
    //             echo "<tr>";
    //             echo "<td>" . htmlspecialchars($row["fname"]) ."</td>";
    //             echo "<td>" . htmlspecialchars($row["lname"]) ."</td>";
    //             echo "<td>". htmlspecialchars($row["username"]) ."</td>";
    //             echo "<td>". htmlspecialchars($row["email"]) ."</td>";
    //             echo "<td>". htmlspecialchars($row["password"]) ."</td>";
    //             echo "<tr>";
    //         }
    //     } else {
    //         echo "nothing";
    //     }
    // } catch (PDOException $e) {
    //     echo "Connection failed:" . $e->getMessage();
    // }
    $hash = password_hash("nicker",
		PASSWORD_DEFAULT);
    
    $verify = password_verify("nicker", $hash);
    echo "$verify"
?>

<div class="listing">
            <?php
                // Prepare and execute query
                $sql = "SELECT id, title, location, rooms, price, image FROM listings WHERE id='1'";
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
                    $listing_id = htmlspecialchars($row['id']);
                }     
            ?>
            <img src="<?php echo $photo; ?>" alt="Hotel Image" class="listing-image"> <!--for images add 2 \ (\\) in path when saving to db -->
            <div class="listing-details">
                <h2 class="listing-title"><?php echo $title; ?></h2>
                <p class="listing-location"><?php echo $location; ?></p>
                <p class="listing-rooms">Rooms: <?php echo $rooms; ?></p>
                <p class="listing-price">€<?php echo $price; ?> per night</p>
                <?php
                if(isset($_SESSION['user'])) {
                    $_SESSION["listing"] = $listing_id;
                ?>   <button class="booking-button" onclick="location.href='booking.php'">Book Now</button>
                <?php    
                }else{        
                ?>   <button class="booking-button" onclick="location.href='login.php'">Login to Book property</button>
                <?php
                }
                ?>
            </div>
</div>    