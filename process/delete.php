<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $profileID = $_POST['id'];

    $sql = "DELETE FROM profiles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $profileID);

    if ($stmt->execute()) {
        echo 'DELETE SUCCESS';
        exit();
    } else {
        $_SESSION['error'] = "Delete failed";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>