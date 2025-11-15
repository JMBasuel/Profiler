<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $toInsert = [];
    $params = [];
    $paramTypes = '';

    $stmt = $conn->prepare("
        CREATE TABLE IF NOT EXISTS profiles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            added DATETIME DEFAULT CURRENT_TIMESTAMP,
            aby VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            student_id VARCHAR(255) NOT NULL,
            age INT,
            birthdate DATE,
            gender VARCHAR(255),
            address VARCHAR(255),
            citizenship VARCHAR(255),
            religion VARCHAR(255),
            phone VARCHAR(255),
            email VARCHAR(255) NOT NULL,
            mother VARCHAR(255),
            father VARCHAR(255),
            guardian VARCHAR(255),
            gphone VARCHAR(255),
            relation VARCHAR(255),
            ename VARCHAR(255),
            ephone VARCHAR(255),
            eaddress VARCHAR(255),
            edited DATETIME DEFAULT CURRENT_TIMESTAMP,
            eby VARCHAR(255),
            father VARCHAR(255),
            files VARCHAR(255)
        );
    ");
    $stmt->execute();

    $map = [
        'aby' => function() { return $_SESSION['account_name'] ?: $_POST['firstname']; },
        'name' => function() { return $_POST['lastname'] . ', ' . $_POST['firstname'] . 
            ($_POST['middlename'] ? '.' . ucwords($_POST['middlename']) : ''); },
        'student_id' => 'student_id',
        'age' => 'age',
        'birthdate' => 'birthdate',
        'gender' => 'gender',
        'address' => 'address',
        'citizenship' => 'citizenship',
        'religion' => 'religion',
        'phone' => 'phone',
        'email' => 'email',
        'mother' => function() { return $_POST['mother'] ?: NULL; },
        'father' => function() { return $_POST['father'] ?: NULL; },
        'guardian' => 'guardian',
        'gphone' => 'gphone',
        'relation' => 'relation',
        'ename' => 'ename',
        'ephone' => 'ephone',
        'eaddress' => 'eaddress'
    ];

    foreach ($map as $field => $key) {
        $new = (is_callable($key)) ? $key() : $_POST[$key];
        $toInsert[] = "$field";
        $params[] = ($field == 'email') ? trim($new) : trim(ucwords($new));
        $paramTypes .= (is_numeric($new) ? 'i' : 's');
    }

    $files = $_FILES['file'];
    $filePaths = [];
    foreach($files['name'] as $key => $name) {
        if ($files['error'][$key] !== UPLOAD_ERR_OK) {
            continue;
        }
        $fileName = preg_replace("/[^A-Z0-9._-]/i", "_", $name);
        $filePath = '../uploads/' . uniqid() . '_' . $fileName;
        if (move_uploaded_file($files['tmp_name'][$key], $filePath)) {
            $filePaths[] = $filePath;
        }
    }

    $toInsert[] = 'files';
    $params[] = json_encode($filePaths);
    $paramTypes .= 's';

    $sql = 'INSERT INTO profiles (' . implode(', ', $toInsert) . ') VALUES (' . implode(', ', array_fill(0, count($toInsert), '?')) . ')';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($paramTypes, ...$params);
    
    if ($stmt->execute()) {
        if (isset($_SESSION['account_name'])) {
            header('Location: ../admin.php');
        } else {
            $_SESSION['success'] = "Data has been submitted";
            header('Location: ../home.php');
        }
        exit();
    } else {
        $_SESSION['error'] = "Data submission failed";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>