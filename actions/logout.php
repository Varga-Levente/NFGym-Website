<?php
    session_start();
    require 'sqlconn.php';
    $timenow = date("Y-m-d H:i:s");
    $icandloginname = $_SESSION["sess_IC_name"]."(".$_SESSION["sess_login_name"].")";
    $addlog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Kilépés", "'.$icandloginname.'", "Alkalmazott kilépet a rendszerből.", "'.date("Y-m-d H:i:s").'")';
    if ($conn->query($addlog) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $addlog . "<br>" . $conn->error;
    }
    session_destroy();
    header('Location: /index.php');
?>