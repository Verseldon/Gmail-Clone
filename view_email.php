<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['email_id'])) {
    // Fetch email details based on the provided email ID and display them
    $email_id = intval($_GET['email_id']);

    $servername = "localhost";
    $username = "root"; // Change this if your MySQL user is different
    $password = ""; // Change this if your MySQL password is different
    $dbname = "gmaildb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("
        SELECT emails.subject, emails.body, users.email AS sender 
        FROM emails 
        JOIN users ON emails.sender_id = users.id 
        WHERE emails.id = ?
    ");
    $stmt->bind_param("i", $email_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $email = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Email Details</title>
            <link rel="stylesheet" href="styles.css">
            <style>
                /* Additional CSS for email content formatting */
                .email-details {
                    padding: 20px;
                }
                .email-details h1 {
                    font-size: 24px;
                    margin-bottom: 10px;
                }
                .email-details p {
                    margin-bottom: 10px;
                }
                .email-details .email-body {
                    border: 1px solid #ddd;
                    width: 500px;
                    height: 300px;
                    padding: 20px;
                    border-radius: 4px;
                    box-sizing: border-box;
                }
            </style>
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
                        <button onclick="window.location.href='logout.php'">Logout</button>
                        <button onclick="window.location.href='compose.php'">Compose</button>
                    </div>
                </div>

                <div class="main">
                    <div class="sidebar">
                        <button id="compose-button" onclick="window.location.href='compose.php'">Compose</button>
                        <ul>
                            <li class="sidebar-item" onclick="window.location.href='home.php'">Inbox</li>
                            <li class="sidebar-item" data-section="starred">Starred</li>
                            <li class="sidebar-item" data-section="sent">Sent</li>
                            <li class="sidebar-item" data-section="drafts">Drafts</li>
                            <li class="sidebar-item" data-section="trash">Trash</li>
                        </ul>
                    </div>

                    <div class="content">
                        <div class="email-details">
                            <h1>Email Details</h1>
                            <p><strong>Subject:</strong> <?php echo htmlspecialchars($email['subject']); ?></p>
                            <p><strong>Sender:</strong> <?php echo htmlspecialchars($email['sender']); ?></p>
                            <div class="email-body">
                                <?php echo nl2br(htmlspecialchars($email['body'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Email not found";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
