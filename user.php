<?php
session_start(); // Start the session
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check for connection error
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if user is logged in
if (isset($_SESSION['id'])) {
    $isLoggedIn = true;

    // Fetch user's data from the database
    $userId = $_SESSION['id'];
    $sql = "SELECT u_name, email, u_image, reg_date FROM users WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userName = $row['u_name'];
        $userEmail = $row['email'];
        $regDate = $row['reg_date']; // Make sure to fetch reg_date here
        $userImage = $row['u_image'];
    } else {
        // Handle user not found error
        echo "User not found.";
        exit;
    }
    $stmt->close();
} else {
    // Redirect user to login page if not logged in
    header("Location: signin.php");
    exit;
}

$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Meta tags, title, and other head content -->
   <style>
       .card {
           width: 300px;
           background-color: rgba(0, 0, 1, 0.1);
           border-radius: 10px;
           box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
           padding: 20px;
           text-align: center;
           margin: 50px auto;
       }

       .profile-image {
           width: 100px;
           height: 100px;
           border-radius: 50%;
           object-fit: cover;
           margin-bottom: 20px;
       }

       .user-name {
           font-size: 20px;
           font-weight: bold;
           margin-bottom: 10px;
       }

       .user-email {
           color: #888;
           margin-bottom: 20px;
           font-size: 15px;
           font-weight: bold;
       }
   </style>
    <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
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
       <div id="menu-btn" class="fas fa-bars"></div>
   </section>
   
   <div class="card">
       <img src="<?php echo htmlspecialchars($userImage); ?>" class="profile-image" alt="Profile Image">
       <div class="user-name">Name: <?php echo htmlspecialchars($userName); ?></div>
       <div class="user-email">Email: <?php echo htmlspecialchars($userEmail); ?></div>
       <div class="user-email">Reg. date: <?php echo htmlspecialchars($regDate); ?></div>
   </div>
</body>
</html>
