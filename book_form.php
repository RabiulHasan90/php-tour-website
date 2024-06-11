<?php
session_start();
// Check if user is not logged in
//if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
 //   header("location: signin.php"); // Redirect to login page
   // exit;
//}
 if(!isset($_SESSION['id'])) {
        header("Location: signin.php");
        exit;
    }

    $user_id = $_SESSION['id'];
     echo "$user_id";
    


$connection =  mysqli_connect('localhost', 'root', '', 'travel');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if(isset($_POST['send'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $location = $_POST['location'];
    $guests = $_POST['guests'];
    $arrivals = $_POST['arrivals'];
    $leaving = $_POST['leaving'];

    $request = "INSERT INTO boo_form (name, email, phone, address, location, guests, arrivals, leaving, user_id) 
                VALUES ('$name', '$email', '$phone', '$address', '$location', '$guests', '$arrivals', '$leaving', '$user_id')";

    if ($connection->query($request) === TRUE) {
        header('location:book.php'); 
    } else {
        echo 'Error: ' . $request . '<br>' . $connection->error;
    }
} else {
    echo 'Something went wrong, please try again!';
}

$connection->close();
?>
