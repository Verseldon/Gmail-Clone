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
    <style>
        /* Additional CSS */
        #compose-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f1f3f4;
        }

        #compose-page h2 {
            margin-bottom: 20px;
        }

        #compose-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%; /* Adjust the width as needed */
            max-width: 600px; /* Maximum width to maintain responsiveness */
        }

        #compose-form input,
        #compose-form textarea {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box; /* Ensure padding is included in the width */
        }

        #compose-form button {
            padding: 10px;
            background-color: #d93025;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
            max-width: 200px; /* Limit button width for better design */
        }

        #compose-form #cancel-button {
            margin-top: 10px;
            background-color: #ccc;
            color: #333;
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
                <span>Welcome, <?php echo $_SESSION['username']; ?></span>
                <button onclick="window.location.href='logout.php'">Logout</button>
                <button onclick="window.location.href='compose.php'">Compose</button>
            </div>
        </div>

        <div class="main">
            <div class="sidebar">
                <button id="compose-button" onclick="window.location.href='compose.php'">Compose</button>
                <ul>
                    <li class="sidebar-item" data-section="inbox">Inbox</li>
                    <li class="sidebar-item" data-section="starred">Starred</li>
                    <li class="sidebar-item" data-section="sent">Sent</li>
                    <li class="sidebar-item" data-section="drafts">Drafts</li>
                    <li class="sidebar-item" data-section="trash">Trash</li>
                </ul>
            </div>

            <div class="content">
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
            </div>
        </div>
    </div>
</body>
</html>
