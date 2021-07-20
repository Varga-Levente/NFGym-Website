<?php
//?company=ASD&workout=DSA&product=SSSS&active=on
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if( isset($_POST['company']) && isset($_POST['workout']) && isset($_POST['product']) ){
    $cstate=0;
    if(isset($_POST['active']) && $_POST['active']=="on"){
        $cstate=1;
    }
    require 'sqlconn.php';

    $checkcontractsql = 'SELECT * FROM gym_contracts WHERE company="'.$_POST["company"].'"';
    $result = $conn->query($checkcontractsql);
    if ($result->num_rows > 0) {
        echo "Már van ilyen néven szerződés a rendszerben."; 
        header("Location: ../admin/contracts.php?err=Már van ilyen néven szerződés a rendszerben!");   
    } else {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Új szerződés", "'.$icandloginname.'", "Új szerződés lett létrehozva vele: '.$_POST['company'].'", "'.date("Y-m-d H:i:s").'")';
        $addusersql = 'INSERT INTO gym_contracts (company, discount_edzes, discount_termek, `state`) VALUES ("'.$_POST['company'].'", "'.$_POST['workout'].'", "'.$_POST['product'].'", "'.$cstate.'")';
        if ($conn->query($addusersql) === TRUE) {
            echo "Új szerződés sikeresen rögzítve.";
            $conn->query($sqllog);
            $conn->close();
            header("Location: ../admin/contracts.php?success=Új szerződés sikeresen rögzítve.");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            $conn->close();
            header("Location: ../admin/contracts.php?err=Adatbátis hiba.");
        }
    }    
}
$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>