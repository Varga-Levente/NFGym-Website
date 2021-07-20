<?php
session_start();
if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"]=="1"){
if( isset($_POST['sells']) && isset($_POST['soldprice']) && isset($_POST['icname']) ){
    require 'sqlconn.php';
    $updaterow = 'UPDATE gym_users SET sells="'.$_POST['sells'].'", sellinusd="'.$_POST['soldprice'].'" WHERE IC_name="'.$_POST['icname'].'"';
    if ($conn->query($updaterow) === TRUE) {
        $icandloginname = $_SESSION['sess_IC_name']."(".$_SESSION['sess_login_name'].")";
        $sqllog = 'INSERT INTO gym_log (type, ki, kiir, mikor) VALUES ("Statisztika módosítás", "'.$icandloginname.'", "Az alábbi alkalmazott statisztikája módosítva lett: '.$_POST['icname'].'", "'.date("Y-m-d H:i:s").'")';
        $conn->query($sqllog);
        echo "Record updated successfully";
        $conn->close();
        header("Location: ../admin/sells.php?success=Az alkalmazott eladási adatai szerkesztve.");
    } else {
        echo "Error updating record: " . $conn->error;
        $conn->close();
        header("Location: ../admin/sells.php?err=Adatbázis hiba.");
    }
}

$conn->close();
}else{
    header("Location: ../index.php?err=Az oldal használatához admin-nak kell lenned!");
}
?>