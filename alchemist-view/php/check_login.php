<?php
session_start();

$host = $_POST["host"];
$db = $_POST["db_name"];
$user = $_POST["user"];
$pwd = $_POST["pwd"];

$mysqli = new mysqli($host, $user, $pwd, $db);

if ($mysqli->connect_errno) {
    $err_msg = $mysqli->connect_errno .  " - " . $mysqli->connect_error;
    header("Location: ../index.php?error=$err_msg");
    exit();
}
else{
	$mysqli->close();

	$_SESSION["hostname"] = $host;
	$_SESSION["database"] = $db;
	$_SESSION["username"] = $user;
	$_SESSION["password"] = $pwd;

	header("Location: ../dashboard.php");
	exit();
}
	
?>