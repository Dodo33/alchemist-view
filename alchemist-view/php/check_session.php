<?php

if(isset($_SESSION["hostname"]) and isset($_SESSION["username"]) and isset($_SESSION["password"]) and isset($_SESSION["database"])){
    $mysqli = new mysqli($_SESSION["hostname"], $_SESSION["username"], $_SESSION["password"], $_SESSION["database"]);

    if ($mysqli->connect_errno) {
        $err_msg = $mysqli->connect_errno .  " - " . $mysqli->connect_error;
    	header("Location: ../index.php?error=$err_msg");
    	exit();
    }
}
else{
    header("Location: ../index.php");
}

?>