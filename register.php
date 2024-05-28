<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Gmail Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="register-page">
        <h2>Register</h2>
        <form id="register-form" action="register_process.php" method="POST">
            <input type="text" name="username" id="reg-username" placeholder="Username" required>
            <input type="password" name="password" id="reg-password" placeholder="Password" required>
            <input type="email" name="email" id="reg-email" placeholder="Email" required>
            <button type="submit" id="register-button">Register</button>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
