<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $toUpdate = [];
    $params = [];
    $paramTypes = '';

    $map = [
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
        'mother' => function() { return empty($_POST['mother']) ? NULL : $_POST['mother']; },
        'father' => function() { return empty($_POST['father']) ? NULL : $_POST['father']; },
        'guardian' => 'guardian',
        'gphone' => 'gphone',
        'relation' => 'relation',
        'ename' => 'ename',
        'ephone' => 'ephone',
        'eaddress' => 'eaddress'
    ];

    foreach ($map as $field => $key) {
        $new = (is_callable($key)) ? $key() : $_POST[$key];
        if ($new !== $_SESSION[$field]) {
            $toUpdate[] = "$field=?";
            $params[] = ($field == 'email') ? trim($new) : trim(ucwords($new));
            $paramTypes .= (is_numeric($new) ? 'i' : 's');
        }
    }

    if (count($toUpdate) > 0) {
        $eby = $_SESSION['account_name'];
        $toUpdate[] = "eby=?";
        $params[] = $eby;
        $id = $_POST['id'];
        $params[] = $id;
        $paramTypes .= 'ssi';

        $sql = 'UPDATE profiles SET '. implode(', ', $toUpdate) . ' WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($paramTypes, ...$params);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header('Location: ../admin.php');
            exit();
        } else {
            $_SESSION['error'] = "Data edit failed";
            header('Location: ../home.php');
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "No changes made";
        header('Location: ../home.php');
        exit();
    }

    $conn->close();
}
?>