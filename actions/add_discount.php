<?php
//?discountname=Teszt&discountlabel=100%25-os+kedvezmény&discountpecent=100&active=on
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if( isset($_POST['discountname']) && isset($_POST['discountlabel']) && isset($_POST['discountpecent']) ){
    $dstate=0;
    if(isset($_POST['active']) && $_POST['active']=="on"){
        $dstate=1;
    }
    require 'sqlconn.php';

    $checkcontractsql = 'SELECT * FROM gym_contracts WHERE company="'.$_POST["company"].'"';
    $result = $conn->query($checkcontractsql);
    if ($result->num_rows > 0) {
        echo "Már van ilyen néven szerződés a rendszerben."; 
        header("Location: ../admin/contracts.php?err=Már van ilyen néven szerződés a rendszerben!");   
    } else {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Új kedvezmény", "'.$icandloginname.'", "Új kedvezmény lett létrehozva: '.$_POST['discountname'].'", "'.date("Y-m-d H:i:s").'")';
        $addusersql = 'INSERT INTO gym_discounts (name, label, szazalek, `state`) VALUES ("'.$_POST['discountname'].'", "'.$_POST['discountlabel'].'", "'.$_POST['discountpecent'].'", "'.$dstate.'")';
        if ($conn->query($addusersql) === TRUE) {
            echo "Új kedvezmény sikeresen rögzítve.";
            $conn->query($sqllog);
            $conn->close();
            header("Location: ../admin/discounts.php?success=Új kedvezmény sikeresen rögzítve.");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
            header("Location: ../admin/discounts.php?err=Adatbátis hiba.");
        }
    }    
}
$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>