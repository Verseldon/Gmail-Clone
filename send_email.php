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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST["to"];
    $subject = $_POST["subject"];
    $body = $_POST["body"];

    // Fetch receiver ID from users table
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $to);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($receiver_id);
        $stmt->fetch();

        // Insert email into emails table
        $stmt = $conn->prepare("INSERT INTO emails (receiver, subject, body) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $receiver_id, $subject, $body);

        if ($stmt->execute()) {
            $email_id = $stmt->insert_id; // Get the ID of the inserted email

            // Insert record into inbox table for the receiver
            $sender_id = $_SESSION['user_id'];
            $stmt = $conn->prepare("INSERT INTO inbox (id, e_sender) VALUES (?, ?)");
            $stmt->bind_param("ii", $email_id, $sender_id);

            if ($stmt->execute()) {
                // If the sender and receiver are the same, also insert into the sender's inbox
                if ($receiver_id == $sender_id) {
                    $stmt = $conn->prepare("INSERT INTO inbox (id, e_sender) VALUES (?, ?)");
                    $stmt->bind_param("ii", $email_id, $sender_id);
                    $stmt->execute();
                }
                echo "Email stored successfully!";
            } else {
                echo "Failed to update inbox. Please try again.";
            }
        } else {
            echo "Failed to store email. Please try again.";
        }
        $stmt->close();
    } else {
        echo "Receiver email not found.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
