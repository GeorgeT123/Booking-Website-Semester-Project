<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script>
</head>
<body>
    <div class="navbar" id="nav">
        <a href="login.php" class="loginLogout" id="login_logout">Login</a>
        <a href="create_listing.php">Create Listing</a>
        <a href="index.php">Feed</a>
    </div>
    <?php
            if(isset($_SESSION['user'])) {
                // destroy and end the session
                session_unset();
                session_destroy();        
        ?>      <h2 style="text-align: center;">Successful logout.</h2> 
        <?php
            }
        ?>
<?php
    $servername = "mysql:host=127.0.0.1; dbname=ds_estate";
    $username= "root";
    $password = "";
    try {
        // Create a PDO instance
        $conn = new PDO ($servername, $username, $password); $conn->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Prepare and execute query
        $sql = "SELECT fname, lname, username, email, password FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // Fetch all rows
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Connection failed:" . $e->getMessage();
    }
?>

    <div id="form-container">
        <div id="login">
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required minlength="4" maxlength="10">
                <input type="submit" value="Login">
            </form>
        </div>
        <p id="register">Click here to <a href="register.php">Register</a>, if you don't have an account.</p>
    </div>    

    <?php
       if ($_SERVER['REQUEST_METHOD'] == 'POST'){   

            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check if the username exists
            $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetchColumn();
            
            $sql = "SELECT password FROM users WHERE username = '$username'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $hash = $stmt->fetchColumn();  
            $verify = password_verify($password, $hash);

            if ($user && $verify) {
                echo "<script>login_success();</script>";
                $_SESSION["user"] = $username;
                exit();
            }
            else{
                echo "<script>login_error();</script>";
            }
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