<?php
$servername = "localhost"; // Host name
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbName = "kpopquizees"; // Database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define $myusername, $mypassword, and $name
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the "myusername" and "mypassword" keys are set in the $_POST array
    if (isset($_POST['myemail']) && isset($_POST['mypassword'])) {
        $email = $_POST['myemail'];
        $password = $_POST['mypassword'];

        // Now you can use $username and $password in your authentication logic.
    } else {
        // Handle the case where the keys are not set (e.g., display an error message).
        echo "<p>Wrong Email or Password. Please try again.";
    }
}

if (isset($username) && isset($password)) {
    $sql = "SELECT email, password FROM admin WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Redirect to "homeadmin.php" upon successful login
        header("location: home.txt.php");
        exit();
    } else {
        echo "<p>Wrong Email or Password. Please try again.";
    }
}

$conn->close();
?>