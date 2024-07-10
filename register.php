<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script>
</head>
<body>

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

    <div class="navbar" id="nav">   
        <div class="desktop">
            <a href="login.php" id="login_logout">Login</a>      
            <a href="create_listing.php" class="loginLogout">Create Listing</a>
            <a href="index.php">Feed</a>
        </div>

        <div class="mobile">
            <input class="menu-btn" type="checkbox" id="menu-btn" />
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
            <ul class="menu">
                <li><a href="login.php" id="login_logout" class="loginLogout">Login</a></li>
                <li><a href="create_listing.php">Create Listing</a></li>
                <li><a href="index.php">Feed</a></li>
            </ul>
        </div>
    </div>

    <div id="form-container">
        <div id="register">
            <form action="register.php" method="post">
                <input type="text" name="fname" placeholder="First Name" required>
                <input type="text" name="lname" placeholder="Last Name" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="E-Mail" required>
                <input type="password" name="password" placeholder="Password" id="passw" required minlength="4" maxlength="10">
                <p id="password-error" style="color:red; display:none;">Password must contain at least one special character.</p>
                <script>
                    //check if password contains special character
                    document.getElementById('passw').addEventListener('input', function() {
                        var password = this.value;
                        var errorMessage = document.getElementById('password-error');
                        var specialCharPattern = /[!@#$%^&*(),.?":{}|<>]/g;

                        if (specialCharPattern.test(password)) {
                            errorMessage.style.display = 'none';
                            document.querySelector('input[type="submit"]').disabled = false;
                        } else {
                            errorMessage.style.display = 'block';
                            document.querySelector('input[type="submit"]').disabled = true; 
                        }
                    });
                </script>
                <!-- <script>
                    //password checker for special characters
                    const input = document.getElementById("passw");
                    input.onkeyup() = function() {
                        let special_characters = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
                        if (!input.value.match(special_characters)) {
                            input.appendChild(document.createElement("p").innerHTML="Please enter at least one special character.")
                        }
                    }   
                </script> -->
                <input type="submit" value="Register">
            </form>
        </div>
    </div>    

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){   

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Check if the username already exists
            $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['username' => $username]);
            $usernameExists = $stmt->fetchColumn();
            
            // Check if the email already exists
            $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            $emailExists = $stmt->fetchColumn();

            if ($usernameExists) {
                echo "<script>username_validation();</script>";
            } elseif ($emailExists) {
                echo "<script>email_validation();</script>";
            } else {
                // If no existing user found, insert new user
                $sql = "INSERT INTO users (fname, lname, username, email, password) VALUES (:fname, :lname, :username, :email, :password)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':fname', $fname);
                $stmt->bindParam(':lname', $lname);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $password = password_hash($password, PASSWORD_DEFAULT); // Ensure the password is hashed
                $stmt->bindParam(':password', $password);

                $stmt->execute();

                header("Location: login.php");
                exit();
            }
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