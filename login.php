<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gmail Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="login-page">
        <h2>Login</h2>
        <form id="login-form" action="login_process.php" method="POST">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" id="login-button">Login</button>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>