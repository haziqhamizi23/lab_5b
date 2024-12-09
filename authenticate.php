<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";  // Replace if needed
$password = "";      // Replace if needed
$dbname = "lab5b"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user data in session
            $_SESSION['matric'] = $user['matric'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            // Redirect to display_users.php
            header("Location: display_users.php");
            exit();
        } else {
            // Invalid password
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        // User not found
        header("Location: login.php?error=1");
        exit();
    }
}

$conn->close();
?>
