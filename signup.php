<?php
session_start();
// if(!isset($_SESSION['id'])) {
  
//     header("Location: signin.php");
//     exit;
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup_styles.css">
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <form action="#" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="userimage">Userimage:</label>
            <input type="text" id="userimage" name="userimage" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Sign Up</button>
            <p style="color: red;">Already have an account? <a href="signin.php">Sign In</a></p>
        </form>
        <?php
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $name = $_POST['username'];
            $img = $_POST['userimage'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $servername = "localhost";
            $db_username = "root";
            $db_password = "";

            // Create connection
            $conn = new mysqli($servername, $db_username, $db_password);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query("SHOW DATABASES LIKE 'Travel'");
            if ($result->num_rows == 0) {
                // Database does not exist, create it
                $sql = "CREATE DATABASE Travel";
                if ($conn->query($sql) === TRUE) {
                    echo "Database created successfully";
                } else {
                    echo "Error creating database: " . $conn->error;
                }
            }

            $conn->query("USE Travel");

            $result = $conn->query("SHOW TABLES LIKE 'Users'");
            if ($result->num_rows == 0) {
                // Table does not exist, create it
                $sql = "CREATE TABLE Users (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    u_image VARCHAR(255) NOT NULL,
                    u_name VARCHAR(30) NOT NULL,
                    email VARCHAR(50) NOT NULL,
                    u_password VARCHAR(255) NOT NULL,
                    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
                if ($conn->query($sql) === TRUE) {
                    echo "Table Users created successfully";
                } else {
                    echo "Error creating table: " . $conn->error;
                }
            }

            // Check if the email already exists
            $email_check_query = "SELECT * FROM Users WHERE email='$email' LIMIT 1";
            $result = $conn->query($email_check_query);

            if ($result->num_rows > 0) {
                echo "<p style='color: red;'>Email already exists. Please use a different email.</p>";
            } else {
                // Hash the password before storing it in the database
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO Users (u_name, u_image, email, u_password) VALUES ('$name', '$img', '$email', '$password')";
                if ($conn->query($query) === TRUE) {
                    header("Location: signin.php");
                    exit;
                } else {
                    echo "Error: " . $conn->error;
                }
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>
