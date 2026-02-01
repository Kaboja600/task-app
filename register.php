<?php
include "db.php";

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username,password) VALUES (?,?)");
    if ($stmt) {
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth-page">

    <div class="auth-card">
        <h2>Create Account</h2>

        <form method="POST">
            <input type="text" name="username" required placeholder="Username">
            <input type="password" name="password" required placeholder="Password">
            <button type="submit" name="register">Register</button>
        </form>

        <p class="auth-link">
            Already have an account?
            <a href="index.php">Login</a>
        </p>
    </div>

</body>

</html>