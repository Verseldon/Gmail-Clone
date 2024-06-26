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

// Fetch emails from the inbox but exclude those sent by the logged-in user to others
$stmt = $conn->prepare("
    SELECT emails.id, emails.subject, emails.body, users.email as sender_email
    FROM inbox 
    JOIN emails ON inbox.email_id = emails.id 
    JOIN users ON emails.sender_id = users.id 
    WHERE inbox.user_id = ? AND (emails.sender_id != ? OR emails.receiver_id = ?)
    ORDER BY emails.id DESC
");
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$emails = [];
while ($row = $result->fetch_assoc()) {
    $emails[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail Clone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="main-page">
        <div class="header">
            <div class="logo">
                <img src="https://ssl.gstatic.com/ui/v1/icons/mail/rfr/logo_gmail_lockup_default_1x_r2.png" alt="Gmail Logo">
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Search mail">
            </div>
            <div class="header-right">
                <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                <button onclick="window.location.href='logout.php'">Logout</button>
                <button onclick="window.location.href='compose.php'">Compose</button>
            </div>
        </div>

        <div class="main">
            <div class="sidebar">
                <button id="compose-button" onclick="window.location.href='compose.php'">Compose</button>
                <ul>
                    <li class="sidebar-item" onclick="window.location.href='home.php'" data-section="inbox">Inbox</li>
                    <li class="sidebar-item" data-section="starred">Starred</li>
                    <li class="sidebar-item" data-section="sent">Sent</li>
                    <li class="sidebar-item" data-section="drafts">Drafts</li>
                    <li class="sidebar-item" data-section="trash">Trash</li>
                </ul>
            </div>

            <div class="content" id="content">
                <div class="toolbar">
                    <button>Refresh</button>
                    <button>More</button>
                </div>
                <div class="email-list" id="email-list">
                    <?php foreach ($emails as $email): ?>
                        <a href="view_email.php?email_id=<?php echo $email['id']; ?>" class="email-item-link">
                            <div class="email-item">
                                <div class="email-sender"><?php echo htmlspecialchars($email['sender_email']); ?></div>
                                <div class="email-subject"><?php echo htmlspecialchars($email['subject']); ?></div>
                                <div class="email-snippet"><?php echo htmlspecialchars(substr($email['body'], 0, 50)); ?>...</div>
                                <button class="trash-button" onclick="trashEmail(<?php echo $email['id']; ?>)">Trash</button>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="script2.js"></script>
</body>
</html>
