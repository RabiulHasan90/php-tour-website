<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sample Form</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    
    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 300px;
    }
    
    input[type="password"],
    input[type="email"],
    textarea {
        width: calc(100% - 12px);
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

<form action="#" method="post">
    
    
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
    
    <input type="submit" value="Submit">
    <p style="color: red;">Are you new? <a href="signup.php">Sign Up</a></p>
      
    <p style="color: red;">use without subscription <a href="home.php">back to home</a></p>
</form>

</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        

        $servername = "localhost";
        $db_username = "root";
        $db_password = "";

        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $query = "Use Travel";

        if ($conn -> query($query) === true)
        {
        // echo "Success";
        }
        else
        {
            die("Error");
        }

        $sql = "SELECT id FROM Users WHERE email='$email' and u_password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {

             setcookie("id", $row['id'], time() + (86400 * 30), "/");
            
            $_SESSION['id'] = $row['id'];
           
          
               header("Location: home.php");
        }
        } else {
        echo '<p>No Such User</p>';
        }
    }
?>
