<?php
    session_start();
    if(!isset($_SESSION['id'])) {
        header("Location: signin.php");
        exit;
    }

    $user = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }
        
        .my-booking {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-column-gap: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .my-booking h2 {
            margin-top: 0;
            color: #333;
        }
        
        .my-booking p {
            color: #555;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .my-booking p span {
            color: #888;
            font-weight: bold;
        }

        .my-booking .details {
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }

        .navbar a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .navbar a:hover {
            color: #007bff;
        }
        
        form {
            margin-bottom: 20px;
        }
        
        form label {
            font-size: 16px;
            color: #333;
            font-weight: bold;
        }
        
        form input[type="text"] {
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: calc(100% - 22px);
        }
        
        form button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        
        form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <section class="header">
        <a href="home.php" class="logo">travel.</a>
        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="package.php">package</a>
            <a href="book.php">book</a>
        </nav>
    </section>
    
    <div class="container">
        <h1>My Booking List</h1>
        
        <!-- Search Form -->
        <form action="" method="get">
            <label for="search">Search by Booking Name:</label>
            <input type="text" id="search" name="search">
            <button type="submit">Search</button>
        </form>

        <?php
        // Establish Database Connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "travel";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if search query is set
        if(isset($_GET['search'])) {
            $search = $_GET['search'];
            // Execute Query with search filter
            $sql = "SELECT * FROM boo_form WHERE location LIKE '%$search%' AND user_id = '$user'";
        } else {
            // Execute Query without search filter
            $sql = "SELECT * FROM boo_form WHERE user_id = '$user'";
        }

        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div class='my-booking'>";
                echo "<div class='details'>";
                echo "<h2>Name: " . $row["name"] . "</h2>";
                echo "<p><span>Email:</span> " . $row["email"] . "</p>";
                echo "<p><span>Phone:</span> " . $row["phone"] . "</p>";
                echo "<p><span>Address:</span> " . $row["address"] . "</p>";
                echo "</div>";
                echo "<div class='details'>";
                echo "<p><span>Location:</span> " . $row["location"] . "</p>";
                echo "<p><span>Guests:</span> " . $row["guests"] . "</p>";
                echo "<p><span>Arrivals:</span> " . $row["arrivals"] . "</p>";
                echo "<p><span>Leaving:</span> " . $row["leaving"] . "</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "No products found";
        }

        // Close Connection
        $conn->close();
        ?>
    </div>
</body>
</html>
