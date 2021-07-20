<?php
//?company=Benny%27s&workout=ingyenes+edzés+%28+tagságin+kívül+%29&product=nincs+kedvezmény&active=on
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if( isset($_POST['company']) && isset($_POST['workout']) && isset($_POST['product']) && isset($_POST['id']) ){
    $active="0";
    if(isset($_POST['active']) && $_POST['active']=="on"){
        $active="1";
    }
    $updaterow = 'UPDATE gym_contracts SET company="'.$_POST['company'].'", discount_edzes="'.$_POST['workout'].'", discount_termek="'.$_POST['product'].'", state="'.$active.'" WHERE ID="'.$_POST['id'].'"';
    $successmessage = "A szerződés sikeresen módosítva lett!";
    

    require 'sqlconn.php';
    
    if ($conn->query($updaterow) === TRUE) {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Szerződés módisítás", "'.$icandloginname.'", "Az alábbi szerződés módosítva lett: '.$_POST['company'].'", "'.date("Y-m-d H:i:s").'")';
        $conn->query($sqllog);
        echo "Record updated successfully";
        $conn->close();
        header("Location: ../admin/contracts.php?success=".$successmessage);
    } else {
        echo "Error updating record: " . $conn->error;
        $conn->close();
        header("Location: ../admin/contracts.php?err=Adatbázis hiba.");
    }
}

$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>