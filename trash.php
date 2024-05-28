<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root"; // Change this if your MySQL user is different
$password = ""; // Change this if your MySQL password is different
$dbname = "gmaildb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch emails from the trash folder
$stmt = $conn->prepare("
    SELECT emails.id, emails.subject, emails.body, users.email as sender_email
    FROM trash 
    JOIN emails ON trash.email_id = emails.id 
    JOIN users ON emails.sender_id = users.id 
    WHERE trash.user_id = ?
    ORDER BY emails.id DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$trashedEmails = [];
while ($row = $result->fetch_assoc()) {
    $trashedEmails[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trashed Emails - Gmail Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="trashed-emails">
        <h2>Trashed Emails</h2>
        <div class="email-list">
            <?php foreach ($trashedEmails as $email): ?>
                <div class="email-item">
                    <div class="email-sender"><?php echo htmlspecialchars($email['sender_email']); ?></div>
                    <div class="email-subject"><?php echo htmlspecialchars($email['subject']); ?></div>
                    <div class="email-snippet"><?php echo htmlspecialchars(substr($email['body'], 0, 50)); ?>...</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
