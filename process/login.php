<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        CREATE TABLE IF NOT EXISTS account (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            name VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");
    $stmt->execute();

    $stmt = $conn->prepare("SELECT name, password FROM account WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($accountName, $hashedPassword);
    $stmt->fetch();
    
    if ($accountName) {
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['account_name'] = $accountName;
            header("Location: ../admin.php");
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Incorrect username";
        header("Location: ../login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>