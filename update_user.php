<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "lab5b"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $accessLevel = $_POST['accessLevel'];

    $updateSQL = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $stmt = $conn->prepare($updateSQL);
    $stmt->bind_param("sss", $name, $accessLevel, $matric);
    if ($stmt->execute()) {
        echo "<script>alert('Record updated successfully!');</script>";
        header("Location: manage_user.php");
        exit();
    } else {
        echo "<script>alert('Error updating record.');</script>";
    }
    $stmt->close();
}


if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];
    $selectSQL = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($selectSQL);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>
    <h1>Update User</h1>
    <form action="update_user.php" method="post">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($user['matric']); ?>" readonly><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>

        <label for="accessLevel">Access Level:</label>
        <input type="text" id="accessLevel" name="accessLevel" value="<?php echo htmlspecialchars($user['role']); ?>" required><br><br>

        <button type="submit">Update</button>
        <a href="manage_users.php">Cancel</a>
    </form>
</body>
</html>

<?php
$conn->close();
?>
