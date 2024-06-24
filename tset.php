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

        if (!empty($result)) {
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["fname"]) ."</td>";
                echo "<td>" . htmlspecialchars($row["lname"]) ."</td>";
                echo "<td>". htmlspecialchars($row["username"]) ."</td>";
                echo "<td>". htmlspecialchars($row["email"]) ."</td>";
                echo "<td>". htmlspecialchars($row["password"]) ."</td>";
                echo "<tr>";
            }
        } else {
            echo "nothing";
        }
    } catch (PDOException $e) {
        echo "Connection failed:" . $e->getMessage();
    }
?>