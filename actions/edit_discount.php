<?php
//?discountname=30%25-oss&discountlabel=30%25-os+kedvezmény&discountpecent=30&active=on
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if( isset($_POST['discountname']) && isset($_POST['discountlabel']) && isset($_POST['discountpecent']) && isset($_POST['id']) ){
    $active="0";
    if(isset($_POST['active']) && $_POST['active']=="on"){
        $active="1";
    }
    $updaterow = 'UPDATE gym_discounts SET name="'.$_POST['discountname'].'", label="'.$_POST['discountlabel'].'", szazalek="'.$_POST['discountpecent'].'", state="'.$active.'" WHERE ID="'.$_POST['id'].'"';
    $successmessage = "A kedvezmény sikeresen módosítva lett!";
    

    require 'sqlconn.php';
    
    if ($conn->query($updaterow) === TRUE) {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Kedvezmény módisítás", "'.$icandloginname.'", "Az alábbi kedvezmény módosítva lett: '.$_POST['discountname'].'", "'.date("Y-m-d H:i:s").'")';
        $conn->query($sqllog);
        echo "Record updated successfully";
        $conn->close();
        header("Location: ../admin/discounts.php?success=".$successmessage);
    } else {
        echo "Error updating record: " . $conn->error;
        $conn->close();
        header("Location: ../admin/discounts.php?err=Adatbázis hiba.");
    }
}

$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>