<?php
session_start(); // Start the session to store user data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            width: 300px;
            margin: 0 auto;
        }
        label, input, button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($_GET['error'])): ?>
        <p class="error">Invalid matric or password. Please try again.</p>
    <?php endif; ?>

    <form action="authenticate.php" method="post">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="index.html">Register here</a></p>
</body>
</html>
