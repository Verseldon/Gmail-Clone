<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Content-Type: application/json");
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['email_id'])) {
    $email_id = intval($_GET['email_id']);

    $servername = "localhost";
    $username = "root"; // Change this if your MySQL user is different
    $password = ""; // Change this if your MySQL password is different
    $dbname = "gmaildb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        header("Content-Type: application/json");
        echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
        exit();
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
        header("Content-Type: application/json");
        echo json_encode($email);
    } else {
        header("Content-Type: application/json");
        echo json_encode(["error" => "Email not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    header("Content-Type: application/json");
    echo json_encode(["error" => "Invalid request"]);
}
?>
