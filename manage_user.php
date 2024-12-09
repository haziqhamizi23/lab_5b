<?php

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "lab5b"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['delete'])) {
    $matric = $_GET['delete'];
    $deleteSQL = "DELETE FROM users WHERE matric = ?";
    $stmt = $conn->prepare($deleteSQL);
    $stmt->bind_param("s", $matric);
    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting record.');</script>";
    }
    $stmt->close();
    header("Location: manage_user.php");
    exit();
}


$sql = "SELECT matric, name, role AS accessLevel FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Manage Users</h1>
    <table>
        <thead>
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Access Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['matric']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['accessLevel']) . "</td>";
                    echo "<td>";
                    echo "<a href='update_user.php?matric=" . urlencode($row['matric']) . "'>Update</a> | ";
                    echo "<a href='manage_user.php?delete=" . urlencode($row['matric']) . "' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
