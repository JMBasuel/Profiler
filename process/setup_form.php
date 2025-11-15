<?php
session_start();
if (isset($_POST['id'])) $_SESSION['id'] = $_POST['id'];
if (isset($_POST['firstname'])) $_SESSION['firstname'] = $_POST['firstname'];
if (isset($_POST['middlename'])) $_SESSION['middlename'] = $_POST['middlename'];
if (isset($_POST['lastname'])) $_SESSION['lastname'] = $_POST['lastname'];
$_SESSION['name'] = $_SESSION['lastname'] . ', ' . $_SESSION['firstname'] . 
                    ($_SESSION['middlename'] ? '.' . $_SESSION['middlename'] : '');
if (isset($_POST['student_id'])) $_SESSION['student_id'] = $_POST['student_id'];
if (isset($_POST['age'])) $_SESSION['age'] = $_POST['age'];
if (isset($_POST['birthdate'])) $_SESSION['birthdate'] = $_POST['birthdate'];
if (isset($_POST['gender'])) $_SESSION['gender'] = $_POST['gender'];
if (isset($_POST['address'])) $_SESSION['address'] = $_POST['address'];
if (isset($_POST['citizenship'])) $_SESSION['citizenship'] = $_POST['citizenship'];
if (isset($_POST['religion'])) $_SESSION['religion'] = $_POST['religion'];
if (isset($_POST['phone'])) $_SESSION['phone'] = $_POST['phone'];
if (isset($_POST['email'])) $_SESSION['email'] = $_POST['email'];
if (isset($_POST['mother'])) $_SESSION['mother'] = $_POST['mother'];
if (isset($_POST['father'])) $_SESSION['father'] = $_POST['father'];
if (isset($_POST['guardian'])) $_SESSION['guardian'] = $_POST['guardian'];
if (isset($_POST['gphone'])) $_SESSION['gphone'] = $_POST['gphone'];
if (isset($_POST['relation'])) $_SESSION['relation'] = $_POST['relation'];
if (isset($_POST['ename'])) $_SESSION['ename'] = $_POST['ename'];
if (isset($_POST['ephone'])) $_SESSION['ephone'] = $_POST['ephone'];
if (isset($_POST['eaddress'])) $_SESSION['eaddress'] = $_POST['eaddress'];
if (isset($_POST['files'])) $_SESSION['files'] = $_POST['files'];
?>