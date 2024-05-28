<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compose Email - Gmail Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="compose-page">
        <h2>Compose Email</h2>
        <form id="compose-form" action="send_email.php" method="POST">
            <input type="text" name="to" id="to" placeholder="To" required>
            <input type="text" name="subject" id="subject" placeholder="Subject" required>
            <textarea name="body" id="body" placeholder="Email body" required></textarea>
            <button type="submit" id="send-button">Send</button>
            <button type="button" id="cancel-button" onclick="window.location.href='home.php'">Cancel</button>
        </form>
    </div>
</body>
</html>
